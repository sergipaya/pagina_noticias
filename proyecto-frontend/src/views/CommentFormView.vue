<script>
import { useDataStore } from '../stores/data'
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
        articleId: Number,
        id: Number,
    },
    data() {
        const mySchema = yup.object({
            body: yup.string().required('El contenido del comentario es obligatorio').min(25, 'El comentario debe tener al menos 25 carácteres'),
        })
        return {
            mySchema,
            comentario: '',
            editando: false,
        }
    },
    computed: {
    },
    methods: {
        ...mapActions(useDataStore, ['saveComment', 'getComment']),
        async onSubmit(values) {
            if (this.id) {
                values.id = this.id
            } else {
                values.article_id = this.articleId
            }
            if (await this.saveComment(values)) {
                if (this.id) {
                    this.$router.push('/news/' + this.categoryName + '/' + this.articleId)
                } else {
                    this.$router.push('/news/' + this.categoryName + '/' + this.articleId)
                }
            }
        },
        cancelar() {
            if (confirm('Quieres abandonar esta página?')) {
                this.$router.push('/news/' + this.categoryName + '/' + this.articleId)
            }
        },
    },
    async mounted() {
        if (this.id) {
                this.editando = true
                this.comentario = await this.getComment(this.id)
        }
    },
}
</script>
<template>
    <div class="row">
        <h2 class="m-5 col-12">{{ editando ? 'Editar ' : 'Nuevo ' }}Comentario</h2>
        <Form class="row g-3 align-items-center p-5" :initial-values="comentario" :validation-schema="mySchema" @submit="onSubmit">
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label class="form-label">Comentario</label>
                <Field name="body" v-slot="{ field }" class="form-control">
                  <textarea v-bind="field" cols="50" rows="10" resize="none" class="border-0 rounded p-3"></textarea>
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
            <div class="col-3 p-3">
              <div class="form-group">
                <button type="submit" class="btn btn-secondary">{{ editando ? 'Editar' : 'Añadir' }}</button>
                <button type="reset" class="btn btn-danger mx-2">Reset</button>
                <button type="button" class="btn btn-warning" @click="cancelar()">Cancelar</button>
              </div>
            </div>
          </div>
        </Form>
      </div>      
</template>