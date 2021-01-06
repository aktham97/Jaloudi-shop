<template>
    <div>
        <Header/>
        <br>
        <br>

        <!-- Page Content -->
        <router-view></router-view>
        <br>
        <br>
        <br>
        <!-- /.container -->

        <!-- Footer -->
        <Footer/>
    </div>
</template>
<script>

    import Header from "../components/Header";
    import Footer from "../components/Footer";
    export default {
        components: {Footer, Header}
    }
</script>
<style>

</style>
