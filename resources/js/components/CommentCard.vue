<template>
    <div
        class="position-relative p-3 collapse-show comment-card comment-card--visible"
        :class="{'comment-card--hidden': deleting}"
    >
        <img src="/icons/delete.png" v-if="deletable" @click="deleteComment(id)" class="profile-avatar"/>
        <div class="d-flex flex-row justify-content-start">
            <div>
                <img :src="picture" width="80"
                     class="user-img rounded-circle mr-2" alt="avatar"/>
            </div>
            <div class="mx-4 d-flex flex-column">
                <div class="mt-2 d-flex flex-row align-items-baseline justify-content-start gap-3">
                    <h3 class="text-h3-w500">{{ name }}</h3>
                    <h4 class="d-none d-lg-block text-h4-w400">{{ time }}</h4>
                </div>
                <p class="comment-text">
                    {{ text }}
                </p>
            </div>
        </div>
        <router-link :to="`/comments/${id}`" class="replies-link">
            Reply ({{ repliesCount }} replies)
        </router-link>
    </div>
</template>

<script>
import {ref} from "vue";
import {useRouter} from "vue-router";

export default {
    name: "CommentCard",
    props: {
        id: Number,
        name: String,
        text: String,
        picture: String,
        time: String,
        deletable: Boolean,
        repliesCount: Number
    },
    emits: ['deleted'],
    setup(props, {emit}) {

        const router = useRouter();
        const deleting = ref(false);

        const deleteComment = (id) => {
            deleting.value = true;
            axios.delete(`/api/comment/delete/${id}`)
                .then((response) => {
                    emit('deleted');
                })
            ;
        }

        return {
            deleteComment,
            deleting,
            router
        }
    }
}
</script>
