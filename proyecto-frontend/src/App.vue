<script>
import AppHeader from './components/AppHeader.vue'
import AppMenu from './components/AppMenu.vue'
import AppFooter from './components/AppFooter.vue'
import {useDataStore} from './stores/data.js'
import {useAuthStore} from './stores/auth.js'
import { mapActions, mapState } from 'pinia'

export default {
  components: { 
    AppHeader,
    AppMenu,
    AppFooter,
  },
  computed: {
    ...mapState(useDataStore, ['messages']),
  },
  methods: {
    ...mapActions(useDataStore, {
        loadData: 'loadData',
    }),
    ...mapActions(useAuthStore, {
      loadUserFromToken: 'loadUserFromToken',
    })
  },
  mounted() {
    this.loadData()
    this.loadUserFromToken()
  }
}
</script>

<template>
  <app-header></app-header>

  <div class="container-flex body">
    <app-menu></app-menu>
    <div class="content">
      <router-view></router-view>
    </div>
    <app-footer></app-footer>
  </div>

</template>

<style>
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css");
.body {
  background-color: #c6d8eb;
}
.content {
  max-width: 1600px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 15px;
  padding-right: 15px;
}
</style>
