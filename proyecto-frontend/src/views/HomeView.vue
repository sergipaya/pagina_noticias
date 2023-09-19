<template>
  <div class="row g-5 m-5">
    <h1>Noticias de actualidad</h1>
  </div>
  <div class="row gx-5 mx-5 p-2" v-for="article in latestArticles" :key="article.id">
    <div class="col-md-3 mb-4 d-flex align-items-end justify-content-center">
      <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
        <img :src="article.imageName" :alt="article.title" class="img-fluid w-100 rounded-5" />
      </div>
    </div>
  
    <div class="col-md-9 mb-4 d-flex flex-column align-items-start bg bg-light rounded p-2">
      <div>
        <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3">Actualidad</span>
        <h4><strong>{{article.title}}</strong></h4>
        <p class="text-muted">{{article.description}}</p>
        <a role="button" class="btn btn-primary" :href="article.url">Ir a la noticia</a>
      </div>
    </div>
  </div>
  
</template>

<script>
import { useDataStore } from '../stores/data';
import { mapState } from 'pinia';
export default {
  computed: {
      ...mapState(useDataStore, {
          latestArticles: 'getLastestArticles',
      })
  }
};
</script>