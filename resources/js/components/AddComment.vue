<template>
    <form action="#" @submit.prevent="form.submit()">
        <div class="rounded-bottom full-width add-comment-bottom-bar"
        >
            <div class="mt-3 py-5 px-3">
                <input
                    v-model="form.data.comment"
                    type="text"
                    class="comment-text-input form-control"
                    :class="{'comment-text-input--error': form.errors.comment}"
                    placeholder="Add a comment"
                    aria-label="Add a comment"
                >
                <p v-if="form.errors.comment" class="form-error">{{ form.errors.comment }}</p>
            </div>
            <div class="px-3 pb-5">
                <button type="submit" class="btn comment-btn comment-btn--submit">Post</button>
                <button type="button" class="mx-2 btn comment-btn comment-btn--cancel">Cancel</button>
            </div>
        </div>
    </form>
</template>
<script>
import useForm from "../use/useForm";
import {ref, watch} from "vue";

export default {
    name: 'AddComment',
    props: {
        replyTo: Number | String
    },
    emits: ['added'],
    setup(props, {emit}) {

        const replyTo = ref(null)

        watch(props, (newProps) => {
            replyTo.value = newProps.replyTo
            form.data.reply_to = newProps.replyTo
        })


        const form = useForm({
            url: '/api/comment/add',
            method: 'post',
            data: {
                comment: '',
                reply_to: replyTo.value
            },
            onSuccess(response) {
                form.data.comment = ''
                emit('added')
            },
        });

        return {
            form
        }
    }
}
</script>
