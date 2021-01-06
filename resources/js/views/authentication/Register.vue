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
                            <button class="nav-link btn btn-link"><router-link style="color: #f8fafc" to='/login' >Login</router-link></button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link active btn btn-link"><router-link style="color: #f8fafc" to='/register'>Register</router-link></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <div class="container" >
            <br>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>

                        <div class="card-body">
                            <form method="POST" v-on:submit.prevent="register">
                                <div class="alert alert-danger" v-if="errors.length">
                                    <ul class="mb-0">
                                        <li v-for="error in errors">
                                            {{error}}
                                        </li>
                                    </ul>

                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" v-model="user.name" name="name"  autofocus>
                                    </div>
                                    <div class="invalid-feedback register-errors" v-if="errors.name">{{errors.name[0]}}</div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" v-model="user.email" >
                                    </div>
                                    <div  class="invalid-feedback register-errors" v-if="errors.email">{{errors.email[0]}}</div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" v-model="user.password" >
                                    </div>
                                    <div class="invalid-feedback register-errors" v-if="errors.password">{{errors.password[0]}}</div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="user.password_confirmation">
                                    </div>
                                    <div class="invalid-feedback register-errors" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
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
        <br>
      <Footer></Footer>
    </div>

</template>

<script>
    import * as auth from '../../services/auth_service';
    import Footer from "../../components/Footer";
    export default {
        components: {Footer},
        created() {
        },
        name: "register",
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: []
            }
        },
        methods: {
            register: async function()
            {
                let formData = new FormData();
                formData.append('name', this.user.name);
                formData.append('email', this.user.email);
                formData.append('password', this.user.password);
                formData.append('password_confirmation', this.user.password_confirmation);
                try {
                    const response = await auth.register(formData);
                    this.errors = {};
                    this.$router.push('/login');


                    this.flashMessage.success({
                        message: 'user Stored successfully!',
                        time: 5000
                    });
                }  catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;
                        default:
                            this.flashMessage.error({
                                message: 'Some error occurred , Please try again!',
                                time: 5000
                            });
                            break;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
