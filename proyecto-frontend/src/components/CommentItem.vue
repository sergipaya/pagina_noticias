<script>
import { useAuthStore } from '../stores/auth';
import { useDataStore } from '../stores/data';
import { mapActions, mapState } from 'pinia';
import moment from 'moment';

export default {
    emits: ['itemDeleted'],
    props: {
        categoryName: String,
        articleId: Number,
        id: Number,
    },
    computed: {
        ...mapState(useAuthStore, {
          user: 'user'
        }),
        formattedDate() {
        return moment(this.comentario.created_at).format('DD-MM-YYYY')
    }
    },
    data () {
        return {
            comentario: {},
            isSameUserOrAdmin: false,
        }
    },
    methods: {
        ...mapActions(useDataStore, ['getComment']),
        checkUserOrAdmin() {
            if (this.user !== null) {
                if (this.comentario.user !== undefined && (this.comentario.user.id === this.user.id)) {
                    this.isSameUserOrAdmin = true
                } else {
                    this.user.roles.forEach((role) => {
                        if (role.name === 'admin') {
                            this.isSameUserOrAdmin = true
                        }
                    })
                }
            }
        },
        deleteItem() {
            if (confirm('Quieres borrar el comentario?')) {
            this.$emit('itemDeleted', this.comentario)
            }
        },
    },
    async mounted() {
        this.comentario = await this.getComment(this.id)
        this.checkUserOrAdmin()
    },
}
</script>

<template>
        <div v-if="comentario.user !== undefined" class="d-flex flex-start">
            <div>
                <h6 class="fw-bold mb-1">{{ comentario.user.name }}</h6>
                <div class="d-flex align-items-center mb-3">
                <p class="mb-0 fw-light">
                    {{ formattedDate }}
                </p>
                <a v-if="isSameUserOrAdmin" @click="this.$router.push('/news/' + categoryName + '/' + articleId + '/edit-comment/' + id)" class="link-muted"><i class="bi bi-pen-fill ms-3 fs-6"></i></a>
                <a v-if="isSameUserOrAdmin" @click.stop="deleteItem" class="link-delete"><i class="bi bi-x-square-fill ms-3 fs-6"></i></a>
                </div>
                <p class="pb-2">
                {{ comentario.body }}
                </p>
            </div>
        </div>
</template>

<style scoped>
.link-muted { color: #aaa; } .link-muted:hover { color: #1266f1; }
.link-delete { color: #aaa; } .link-delete:hover { color: #f11230; }

</style>