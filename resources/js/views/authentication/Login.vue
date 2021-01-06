<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <router-link to='/home' class="navbar-brand">AL-JALOUDI Shop</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" >
                        <button class="nav-link active btn btn-link"><router-link style="color: #f8fafc" to='/login' >Login</router-link></button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link btn btn-link"><router-link style="color: #f8fafc" to='/register'>Register</router-link></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <br>
        <br>

        <div class="container">
            <br>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">login</div>

                        <div class="card-body">
                            <form v-on:submit.prevent="login" method="POST" >

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="user.email"  name="email"  >
                                        <div class="invalid-feedback register-errors" v-if="errors.email">{{errors.email[0]}}</div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="user.password" name="password" >
                                        <div class="invalid-feedback register-errors" v-if="errors.password">{{errors.password[0]}}</div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="user.remember_me"  name="remember_me" id="remember_me" >
                                            <label class="form-check-label" for="remember_me">
                                                Remember Me
                                            </label>
                                            <div class="invalid-feedback register-errors" v-if="errors.remember_me">{{errors.remember_me[0]}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button v-on:submit="login" type="submit" class="btn btn-primary" >
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="#">
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <Footer></Footer>
    </div>

</template>

<script>
    import * as auth from '../../services/auth_service';
    import Footer from "../../components/Footer";
    export default {
        name: "login",
        components: {Footer},
        data(){
            return{
                user:{
                    email:'',
                    password:'',
                    remember_me:''

                },
                errors:{},
            }
        },
        methods:{
            login: async function()
            {
                let formData = new FormData();
                formData.append('email', this.user.email);
                formData.append('password', this.user.password);
                formData.append('remember_me', this.user.remember_me);
                try {
                    const response = await auth.login(formData);
                    this.errors = {};
                    this.$router.push('/home');
                    this.flashMessage.success({
                        message: 'user login successfully!',
                        time: 5000
                    });
                } catch (error) {
                    console.log(''+error);
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        case 401:
                            this.flashMessage.error({
                                message: 'User Unauthorized , Please try again!',
                                time: 5000
                            });
                            break;
                        default:
                            this.flashMessage.error({
                                message: 'Some error occurred , Please try again!',
                                time: 5000
                            });
                            break;
                    }
                }

            },

        }
    }
</script>

<style scoped>

</style>
