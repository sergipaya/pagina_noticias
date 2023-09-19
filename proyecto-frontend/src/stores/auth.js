import { defineStore } from 'pinia'
import axios from 'axios'

const SERVER = 'http://proyecto-backend.es/api'
const TOKEN_KEY = 'token'
const USER_KEY = 'user'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    users: [],
    user: null,
  }),
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post(`${SERVER}/login`, credentials)
        const token = response.data.token
        const user = response.data.user

        localStorage.setItem(TOKEN_KEY, token)
        localStorage.setItem(USER_KEY, JSON.stringify(user))

        await this.loadUserFromToken()
      } catch (error) {
        console.error(error)
      }
    },
    async register(credentials) {
      try {
        const response = await axios.post(`${SERVER}/users`, credentials)
      } catch (error) {
        console.error('el usuario ya está registrado')
      }
    },
    async loadUserFromToken() {
        const token = localStorage.getItem(TOKEN_KEY)
        if (token && token !==  "undefined") {
            const user = JSON.parse(localStorage.getItem(USER_KEY))
          try {
            const response = await axios.get(`${SERVER}/users/${user.id}`, {
              headers: {
                Authorization: `Bearer ${token}`
              }
            })
            const userData = response.data
            this.user = userData
          } catch (error) {
            console.error(error)
          }
        }
      },
    logout() {
        localStorage.removeItem(TOKEN_KEY)
        localStorage.removeItem(USER_KEY)
        this.user = null
    },
  },
})
