<script>
import { useAuthStore } from '../stores/auth';
import { mapState } from 'pinia';

  export default {
    computed: {
        ...mapState(useAuthStore, {
            user: 'user',
        })
    },
  };
</script>

<template>
  <div class="row justify-content-center p-5">
    <div class="col-sm-12 col-md-8 col-lg-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title text-center">Panel de usuario</h1>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  </template>
