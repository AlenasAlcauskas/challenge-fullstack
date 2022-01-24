<template>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1>Login</h1>
                            </div>
                        </div>
                        <form action="#" @submit.prevent="form.submit()">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input v-model="form.data.email" type="email" name="email" class="form-control"
                                       id="email" placeholder="Enter email">
                                <div v-if="form.errors.email" class="form-error">{{ form.errors.email }}</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="form.data.password" type="password" name="password" id="password"
                                       class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="login-or">
                                    <hr class="hr-or">
                                    <span class="span-or">or</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p class="text-center">
                                    <a href="/auth/login/google" class="google btn mybtn"><i class="fa fa-google-plus">
                                    </i> Signup using Google
                                    </a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
</template>

<script>
import {useRouter} from "vue-router";
import useForm from "../use/useForm";
import { useStore } from 'vuex'

export default {
    name: "Login",
    setup(props, { root }) {
        const store = useStore();
        const router = useRouter();

        console.log(store.getters.user)

        const form = useForm({
            url: '/auth/login',
            method: 'post',
            data: {
                email: '',
                password: ''
            },
            async onStart() {
                await axios.get('/sanctum/csrf-cookie')
            },
            async onSuccess(response) {
                await store.dispatch("getUser")
                router.push('/comments')
            },
        });

        return {
            form
        }
    }
}
</script>
