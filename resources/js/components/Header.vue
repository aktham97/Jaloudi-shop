<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <router-link to='/home' class="navbar-brand">AL-JALOUDI Shop</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link btn btn-link" v-on:click="logout" href="">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import * as auth from '../services/auth_service'
    export default {
        name: "Header",
        methods: {
            logout: async function(){


                try {
                    const response = await auth.logout();
                    console.log(response);
                    this.$router.push('/');
                    this.flashMessage.success({
                        message: 'user logout successfully!',
                        time: 5000
                    });
                }catch (e) {
                    console.log(e);

                }
            }
        }
    }

</script>

<style scoped>

</style>
