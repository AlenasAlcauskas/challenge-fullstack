<template>
    <div :id="parent ? parent : 'comments'" class="comment-cards">
        <div class="mt-3 comment-cards-container p-0 container shadow w-auto m-3 rounded-3 position-relative">
            <a href="#" class="p-3 logout-link" @click="logOut"> Log out</a>
            <div class="p-3 d-flex flex-column gap-4 h-75">
                <h3 class="p-3 text-h3-w400">
                    {{ comments?.length }}
                    {{ parent ? 'replies' : 'earlier comments' }}</h3>
                <div v-if="comments.length" v-for="comment in comments" :key="comment.id + comment.text">
                    <comment-card
                        :id="comment.id"
                        :name="comment.name"
                        :text="comment.text"
                        :time="comment.time"
                        :picture="comment.picture"
                        :deletable="user.id === comment.user_id"
                        :replies-count="comment.repliesCount"
                        @deleted="getComments()"
                    />
                </div>
                <div v-else class="loader"></div>
            </div>

            <add-comment :reply-to="parent" @added="getComments()"/>
        </div>

    </div>

</template>
<script>
import {ref, computed, watch} from "vue";
import {useStore} from 'vuex'
import AddComment from "../components/AddComment";
import CommentCard from "../components/CommentCard";
import {useRoute, useRouter} from "vue-router";

export default {
    name: "Index",
    components: {AddComment, CommentCard},
    setup() {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        const user = store.getters.user
        const comments = ref([]);
        const parent = computed(() => route.params.parent)

        watch(parent, function(newParent) {
            onChangeParent(newParent)
        })

        const getComments = () => {
            const url = parent.value ? `/api/comment/${parent.value}/replies` : '/api/comments'
            axios.get(url)
                .then(response => {
                    comments.value = response.data.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        store.dispatch('logout')
                    }
                })
        }

        const onChangeParent = (p) => {
            comments.value = []
            getComments(p)
        }

        const logOut = () => {
            store.dispatch('logout').then(() => router.push('/login'));
        }

        getComments()

        return {
            user,
            comments,
            getComments,
            parent,
            onChangeParent,
            logOut
        }
    }
}
</script>

