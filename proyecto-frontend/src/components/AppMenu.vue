<template>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
	    <div class="container-fluid">
	      <h2 class="navbar-brand">HN - Tu portal de noticias</h2>
	      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	      </button>
	    
	      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
	        <ul class="navbar-nav ms-auto ">
	          <li class="nav-item">
                <router-link to="/" class="nav-link mx-2 active" aria-current="page">Actualidad</router-link>
	          </li>
              <li v-for="category in categories" :key="category">
                <router-link :to="`/news/${category}`" class="nav-link mx-2">{{ capitalize(category) }}</router-link>
              </li>
              <li v-if="!user" class="nav-item">
                <router-link to="/login" class="nav-link mx-2">Login</router-link>
            </li>
            <li v-if="!user" class="nav-item">
                <router-link to="/register" class="nav-link mx-2">Registro</router-link>
            </li>
	          <li v-else class="nav-item dropdown">
	            <a class="nav-link mx-2 dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	              {{ user.name }}
                </a>
	            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
	              <li><router-link to="/user-panel" class="dropdown-item">Perfil</router-link></li>
	              <li><button class="dropdown-item" @click="logoutFromStore">Logout</button></li>
	            </ul>
	          </li>
	        </ul>
	      </div>
	    </div>
	    </nav>
</template>

<script>
import { useAuthStore } from '../stores/auth';
import { mapActions, mapState } from 'pinia';

export default {
  data() {
    return {
      categories: ['móviles', 'ciencia', 'guías de compra', 'movilidad'],
    };
  },
    computed: {
        ...mapState(useAuthStore, {
          user: 'user'
        })
    },
    methods: {
        ...mapActions(useAuthStore,['logout']),
        logoutFromStore() {
              this.logout()
              this.$router.push({ name: 'home' })
        },
        capitalize(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    }
};
</script>

<style scoped>
.navbar {
    position: sticky;
    top: 0;
    z-index: 100;
  }
</style>