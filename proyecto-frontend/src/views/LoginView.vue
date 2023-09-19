<template>
  <div id="app" class="row justify-content-center mx-5 py-5 g-5">
    <div class="col-sm-12 col-md-6 col-lg-4 bg bg-light rounded">
      <Form :validation-schema="mySchema" @submit="onSubmit" class="p-3">
        <div class="form-group">
          <label for="email">Email</label>
          <Field name="email" type="email" class="form-control" id="email" />
          <ErrorMessage name="email" class="text-danger" />
        </div>
        <div class="form-group mb-2">
          <label for="password">Password</label>
          <Field name="password" type="password" class="form-control" id="password" />
          <ErrorMessage name="password" class="text-danger" />
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </Form>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/auth';
import { Form, Field, ErrorMessage } from "vee-validate";
import { mapActions } from 'pinia';

export default {
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  methods : {
    ...mapActions(useAuthStore, ['login']),
    onSubmit(values) {
      this.login(values)
      this.$router.push({ name: 'home' })
    },
  },
  data() {
    return {
      mySchema: {
        email: (value) => {
          if (!value) return "Campo requerido";
          const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
          if (!regex.test(value)) return "El formato de email no es correcto";
          return true;
        },
        password: (value) => {
          if (!value) return "Campo requerido";
          return true;
        }
      }
    }
  },
};
</script>

<style scoped>
#app {
  min-height: 500px;
}
</style>