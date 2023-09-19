<script>
import { useDataStore } from '../stores/data'
import { useAuthStore } from '../stores/auth';
import { mapActions, mapState } from 'pinia'
import { Form, Field, ErrorMessage } from "vee-validate"
import * as yup from 'yup'

export default {
    components: {
        Form,
        Field,
        ErrorMessage
    },
    props: {
        categoryName: String,
        id: Number,
    },
    data() {
        const mySchema = yup.object({
            title: yup.string().required('El título es obligatorio').min(5, 'El título debe tener al menos 10 carácteres'),
            description: yup.string().required('La descripción es obligatoria').min(10, 'La descripción debe tener al menos 10 carácteres'),
            body: yup.string().required('El cuerpo es obligatorio').min(50, 'El cuerpo debe tener al menos 50 carácteres'),
            image: yup.mixed().required('El campo de la imagen es requerido')
            .test('fileFormat', 'El formato de la imagen no es válido. Solo se permiten archivos con extensiones .jpg, .jpeg, .png o .gif', value => {
            if (!value) return true; // Si no se ha seleccionado ningún archivo, se considera válido
            const supportedFormats = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            return supportedFormats.includes(value.type)}),
            category: yup.string().required('La categoría es obligatoria'),
        })
        return {
            mySchema,
            article: {},
            editando: false,
        }
    },
    computed: {
        ...mapState(useDataStore, {
            categories: 'categories',
            news: 'news'
        }),
        ...mapState(useAuthStore, {
          user: 'user'
        }),
    },
    methods: {
        ...mapActions(useDataStore, ['saveArticle', 'getArticle', 'getCategories']),
        async onSubmit(values) {
            if (await this.saveArticle(values)) {
                this.$router.push('/news/' + this.categoryName)
            }
        },
        getCategoriesFromStore() {
        this.categories = this.getCategories(this.categoryName)
      },
        cancelar() {
            if (confirm('Quieres abandonar esta página?')) {
                this.$router.push('/news/' + this.categoryName)
            }
        },
    },
    async mounted() {
        this.getCategoriesFromStore()
        if (this.id) {
                this.editando = true
                this.article = await this.getArticle(this.id)
        }
    },
}
</script>
<template>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
          <h2 class="m-2">{{ editando ? 'Editar ' : 'Nueva ' }}Noticia</h2>
          <Form class="row g-3 align-items-center p-2 my-2" :initial-values="article" :validation-schema="mySchema" @submit="onSubmit" enctype="multipart/form-data">
            <div v-if="editando" class="form-group">
              <Field type="text" name="id" class="form-control" disabled hidden/>
            </div>
            <div class="form-group">
              <Field type="text" name="user_id" :value="this.user.id" class="form-control" disabled hidden/>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Título</label>
                  <Field name="title" type="text" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group my-3">
                <ErrorMessage class="alert alert-danger" role="alert" name="title" />
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Descripción</label>
                  <Field name="description" type="text" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group my-3">
                <ErrorMessage class="alert alert-danger" role="alert" name="description" />
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Cuerpo</label>
                  <Field name="body" v-slot="{ field }">
                    <textarea v-bind="field" class="form-control" cols="50" rows="10" style="resize: none;"></textarea>
                  </Field>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group my-3">
                <ErrorMessage class="alert alert-danger" role="alert" name="body" />
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Imagen</label>
                  <Field name="image" type="file" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group my-3">
                <ErrorMessage class="alert alert-danger" role="alert" name="image" />
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group my-3">
                  <Field as="select" class="form-select" name="category">
                    <option disabled selected hidden value=''>Selecciona la categoría</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{category.name}}
                    </option>
                  </Field>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group my-3">
                <ErrorMessage class="alert alert-danger" role="alert" name="category" />
              </div>
            </div>
            <div class="row">
              <div class="col-12 p-3">
                <div class="form-group">
                  <button type="submit" class="btn btn-secondary">{{ editando ? 'Editar' : 'Añadir' }}</button>
                  <button type="reset" class="btn btn-danger mx-2">Reset</button>
                  <button type="button" class="btn btn-warning" @click="cancelar()">Cancelar</button>
                </div>
              </div>
            </div>
          </Form>
        </div>
      </div>
      
</template>