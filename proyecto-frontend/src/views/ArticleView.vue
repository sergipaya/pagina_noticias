<script>
    import { useDataStore } from '../stores/data';
    import { useAuthStore } from '../stores/auth';
    import { mapState, mapActions } from 'pinia';
    import CommentItem from '../components/CommentItem.vue'

export default {
    components: {
      CommentItem
    },
    props: {
        id: String,
        category: Object,
    },
    computed: {
        ...mapState(useDataStore, {
            getArticleById: 'getArticleById',
        }),
        ...mapState(useAuthStore, {
          user: 'user'
        })
    },
    data() {
      return {
        article: {},
        isAdmin: false,
      }
    },
    methods: {
      ...mapActions(useDataStore, ['deleteComment', 'deleteArticle']),
        getArticle() {
            this.article = this.getArticleById(this.id);
      },
      handleItemDeleted(comentario, index) {
        if (comentario !== undefined) {
          this.deleteComment(comentario)
          this.article.comments.splice(index, 1)
        }
      },
      async deleteItem() {
        if (this.article !== undefined) {
           await this.deleteArticle(this.article)
          this.$router.push('/news/' + this.category)
        }
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
        this.getArticle()
      },
    },
    mounted() {
      this.getArticle()
      this.checkAdmin()
    },
}
</script>
<template>
  <div class="row g-5 m-5 text-center">
    <h1>{{ article.title }}</h1>
  </div>
  <div class="row gx-5 m-5 bg bg-light rounded p-3">
    <div class="col-md-4 mb-4 d-flex align-items-start justify-content-start align-self-start">
      <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
        <img :src="`http://proyecto-backend.es/api/images/${article.imageName}`" :alt="article.imageName" class="img-fluid rounded-5 article-img" />
      </div>
    </div>
  
    <div class="col-md-8 mb-4 d-flex flex-column align-items-start p-3">
      <div>
        <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3" v-for="category in article.categories" :key="category.id">
          {{ category.name }}
        </span>
        <h4><strong>{{article.description}}</strong></h4>
        <p class="text-muted">{{article.body}}</p>
        <div class="d-flex justify-content-between">
          <div>
            <a v-if="isAdmin" class="btn btn-primary me-2" @click="this.$router.push('/news/' + category + '/edit-article/' + id)">Editar</a>
            <a v-if="isAdmin" class="btn btn-danger" @click="deleteItem">Borrar</a>
          </div>
          <a class="btn btn-primary" @click="this.$router.push('/news/' + article.categories[0].name.toLowerCase())">Volver</a>
        </div>
      </div>
    </div>
  </div>
  <section>
    <div class="container py-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-10">
          <div class="card text-dark bg bg-light border-0">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Comentarios</h4>
              <button v-if="user" class="btn btn-sm btn-primary" @click="this.$router.push('/news/' + article.categories[0].name.toLowerCase() + '/' + Number(id) + '/add-comment/')">Añadir comentario</button>
            </div>
            <div class="card-body p-4" v-for="comentario, index in article.comments" :key="comentario.id">
              <CommentItem @itemDeleted="handleItemDeleted(comentario, index)" :categoryName="article.categories[0].name.toLowerCase()"
              :articleId="article.id" :id="comentario.id"></CommentItem>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.article-img {
  max-height: 600px;
}
</style>