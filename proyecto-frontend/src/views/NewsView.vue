<script>
import { useDataStore } from '../stores/data';
import { useAuthStore } from '../stores/auth';

import { mapState } from 'pinia';

  export default {
    props: ['category'],
    computed: {
        ...mapState(useDataStore, {
          getNewsByCategory: 'getNewsByCategory',
        }),
        ...mapState(useAuthStore, {
          user: 'user'
        })
    },
    data() {
      return {
        newsByCategory: {},
        categoryName: '',
        isAdmin: false,
      }
    },
    methods: {
      getNews() {
        this.newsByCategory = this.getNewsByCategory(this.category.charAt(0).toUpperCase() + this.category.slice(1))
      },
      categoryToUpperCase() {
        this.categoryName = this.category.charAt(0).toUpperCase() + this.category.slice(1)
      },
      getImageUrl(filename) {
      return 'http://proyecto-backend.es/api/images/' + filename;
    },
    checkAdmin() {
            if (this.user !== null) {
              this.user.roles.forEach((role) => {
                        if (role.name === 'admin') {
                            this.isAdmin = true
                        }
                    })
            }
        },
    },
    watch: {
      $route() {
        this.getNews()
        this.categoryToUpperCase()
      }
    },
    mounted() {
      this.getNews()
      this.categoryToUpperCase()
      this.checkAdmin()
    },
  };
</script>

<template>
  <div class="row g-5 m-5 d-flex align-items-center">
    <div class="col-6">
      <h1>{{ categoryName }}</h1>
    </div>
    <div v-if="isAdmin" class="col-6 d-flex justify-content-end">
      <button class="btn btn-sm btn-primary"
        @click="this.$router.push('/news/' + categoryName + '/add-article/')">
        Añadir noticia
      </button>
    </div>
  </div>
  
  <div class="row gx-5 mx-5 p-2" v-for="article in newsByCategory" :key="article.id">
    <div class="col-md-3 mb-4 d-flex align-items-end justify-content-center">
      <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
        <img :src="`http://proyecto-backend.es/api/images/${article.imageName}`" :alt="article.image" class="img-fluid rounded-5 article-img" />
      </div>
    </div>
  
    <div class="col-md-9 mb-4 d-flex flex-column align-items-start bg bg-light rounded p-2">
      <div>
        <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3" v-for="category in article.categories" :key="category.id">
          {{ category.name }}
        </span>
        <h4><strong>{{article.title}}</strong></h4>
        <p class="text-muted">{{article.description}}</p>
        <router-link class="btn btn-primary" :to="`/news/${category}/${article.id}`">Ir a la noticia</router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.article-img {
  max-height: 200px;
}
</style>