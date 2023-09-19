<template>
  <div id="app" class="row justify-content-center mx-5 p-5 g-5">
    <div class="col-sm-12 col-md-6 col-lg-4  bg bg-light rounded">
      <Form :validation-schema="mySchema" @submit="onSubmit" class="p-3">
        <div class="form-group">
          <label for="name">Nombre</label>
          <Field name="name" type="text" class="form-control" id="name" />
          <ErrorMessage name="name" class="text-danger" />
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <Field name="email" type="email" class="form-control" id="email" />
          <ErrorMessage name="email" class="text-danger" />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <Field name="password" type="password" class="form-control" id="password" />
          <ErrorMessage name="password" class="text-danger" />
        </div>
        <div class="form-group mb-2">
          <label for="password_confirmation">Confirmas Password</label>
          <Field name="password_confirmation" type="password" class="form-control" id="password_confirmation" />
          <ErrorMessage name="password_confirmation" class="text-danger" />
        </div>
        <button type="submit" class="btn btn-primary">Crear cuenta</button>
      </Form>
    </div>
  </div>
  
</template>

<script>
import { useAuthStore } from '../stores/auth';
import { Form, Field, ErrorMessage } from "vee-validate";
import { mapActions } from 'pinia';
import * as yup from 'yup';

export default {
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  methods : {
    ...mapActions(useAuthStore, ['register']),
    onSubmit(values) {
      this.register(values)
      this.$router.push({ name: 'home' })
    },
  },
  data() {
    const mySchema = yup.object({
      name: yup.string().required().min(5),
      email: yup.string().required().email(),
      password: yup.string().required().min(8),
      password_confirmation: yup.string().required().oneOf([yup.ref('password')], 'Passwords do not match'),
    })
    return {
      mySchema
    }
  },
};
</script>

<style scoped>
#app {
  min-height: 500px;
}
</style>