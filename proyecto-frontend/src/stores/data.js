import { defineStore } from 'pinia'

import axios from 'axios'

const SERVER = 'http://proyecto-backend.es/api'
const TOKEN_KEY = 'token'

export const useDataStore = defineStore('data', {
  state: () => ({
    news: [],
    categories: [],
    comments: [],
  }),
  getters: {
    getArticleById: (state) => (id) => {
        return state.news.find((article) => article.id === Number(id)) || {}
    },
    getLastestArticles: (state) => state.news.filter((article) => article.categories[0].id === 1) || {},
    getNewsByCategory: (state) => (searchedCategory) => {
        let filteredNews = []
        state.news.forEach((article) => {
            article.categories.forEach((category) => {
                if (category.name === searchedCategory) {
                    filteredNews.push(article)
                }
            })
        })
        return filteredNews
    },
  },
  actions: {
    async saveArticle(article){
        const token = localStorage.getItem(TOKEN_KEY)
        if (token && token !==  "undefined") {
            try {
                if (article.id) {
                        await axios.put(SERVER + '/news/' + article.id, {
                            title: article.title,
                            description: article.description,
                            body: article.body,
                            image: article.image,
                            categories: [article.category],
                            user_id: article.user_id
                        }, {
                          headers: {
                            Authorization: `Bearer ${token}`,
                          }
                        })
                } else {
                  const response = await axios.post(SERVER + '/news/', {
                    title: article.title,
                    description: article.description,
                    body: article.body,
                    image: article.image,
                    categories: [article.category],
                    user_id: article.user_id
                  }, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                      }
                  })
                }
                this.loadData()
                return true
              } catch (error) {
                alert(error)
                return false
            }
        }
    },
    async saveComment(newComment){
        const token = localStorage.getItem(TOKEN_KEY)
        if (token && token !==  "undefined") {
            try {
                if (newComment.id) {
                        await axios.put(SERVER + '/comments/' + newComment.id, {
                            body: newComment.body
                        }, {
                          headers: {
                            Authorization: `Bearer ${token}`,
                          }
                        })
                } else {
                  const response = await axios.post(SERVER + '/comments/', {
                    body: newComment.body,
                    article_id: newComment.article_id
                  }, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                      }
                  })
                  this.news[Number(newComment.article_id) - 1].comments.push(response.data)
                }
                return true
              } catch (error) {
                alert(error)
                return false
            }
        }
    },
    async getArticle(articleId) {
        try {
            const response = await axios.get(SERVER + '/news/' + articleId)
            return response.data
        } catch (error) {
            alert(error)
            return {}
        }
    },
    async getComment(commentId) {
        try {
            const response = await axios.get(SERVER + '/comments/' + commentId)
            return response.data
        } catch (error) {
            alert(error)
            return {}
        }
    },
    async getNews() {
        try {
            const response = await axios.get(SERVER + '/news')
            return response.data
        } catch (error) {
            alert(error)
            return {}
        }
    },
    async getComments() {
        try {
            const response = await axios.get(SERVER + '/comments/')
            this.comments = response.data
            return response.data
        } catch (error) {
            alert(error)
            return {}
        }
    },
    async getCategories() {
        try {
            const response = await axios.get(SERVER + '/categories/')
            this.categories = response.data
            return response.data
        } catch (error) {
            alert(error)
            return {}
        }
    },
    async deleteArticle(article){
        const token = localStorage.getItem(TOKEN_KEY)
        if (token && token !==  "undefined") {
          try {
            const response = await axios.delete(SERVER + '/news/' + article.id, {
              headers: {
                Authorization: `Bearer ${token}`
              }
            })
            const index = this.news.findIndex(item => item.id === article.id);
            if (index !== -1) {
                this.news.splice(index, 1);
            }
          } catch (error) {
            console.error(error)
          }
        }
    },
    async deleteComment(comment){
        const token = localStorage.getItem(TOKEN_KEY)
        if (token && token !==  "undefined") {
          try {
            const response = await axios.delete(SERVER + '/comments/' + comment.id, {
              headers: {
                Authorization: `Bearer ${token}`
              }
            })
          } catch (error) {
            console.error(error)
          }
        }
    },
    async loadData() {
        try {
            const response = await axios.get(SERVER + '/news')
            this.news = response.data
        } catch (err){
            console.error(err)
        }
    },
  },
})