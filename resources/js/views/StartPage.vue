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
                        <button class="nav-link btn btn-link"><router-link style="color: #f8fafc" to='/register'>Register</router-link></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">



            </div>


            <div class="col-lg-6">
                <br>
                <div class="row">
                        <div class="col-lg-12 col-md-6 mb-4">
                            <div class="card h-100">
                                <img class="card-img-top"
                                     src="../../../public/images/fashionmenclothing.jpg" alt="">
                                <div class="card-body category">
                                    <h4 class="card-title">
                                        Men´s clothing
                                    </h4>
                                    <p class="card-text">jjjjjj</p>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-lg-12 col-md-6 mb-4">
                            <div class="card h-100">
                                <img class="card-img-top"
                                     src="../../../public/images/Womens-Clothing.jpeg" alt="">
                                <div class="card-body category">
                                    <h4 class="card-title">
                                        Women´s clothing
                                    </h4>
                                    <p class="card-text">jjjjjj</p>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-lg-12 col-md-6 mb-4">
                            <div class="card h-100">
                                <img class="card-img-top"
                                     src="../../../public/images/106032900-1563825608021rockets.jpg" alt="">
                                <div class="card-body category" >
                                    <h4 class="card-title">Children's clothing</h4>
                                    <p class="card-text">jjjjjj</p>
                                </div>
                            </div>
                        </div>
                </div>
                <hr style="border: 1px solid #343a40">
                <h6>ABOUT JALOUDI SHOP</h6>
                <p>
                    One of the perks of living in the 21st century is reaping the benefits of technology and Internet and everything that it brings along with it. Internet addicts will swear by the convenience, comfort and speed with which they are enabled to finish their everyday tasks, enlighten themselves, get updates, news, and heck, and even shop online. Discover Jaloudi shop, your online store of clothing and shoes. You will find a wide selection of shoes, dresses; cocktail, formal, party and summer dresses, handbags, accessories and apparel brand internationally recognized. Choose from hundreds of models of shoes for men, women and children from boots, sandals, clogs, ballerinas, etc. All styles and trends are available at the best price and buy Jaloudi shop is easy, fast and safe! We offer the entire catalog of womens wear, mens wear like Levi´s, Hugo Boss, Lacoste, Pepe Jeans, Quicksilver, Roxy, Bumpy, Superdry, Wrangler. Check out all our categories and enjoy the arrival of new products for 2019. Jaloudi shop proposes very exclusive and flash offers, model sales and our outlet sales; you´ll get cheap shoes or clothing brand with the lowest price guaranteed. You can complete your wardrobe with our selection of polo shirts, shirts, dresses in different colours, jeans, sweatshirts, pants, jackets and even vintage clothes! Shop here for designer suits for men, shirts, shorts and everything that a man loves to wear. As for our exclusive kids wear section, it is neatly compartmentalized into baby clothes online, boys’ clothes and girls’ clothes where you can shop to your heart’s desire for boys’ casual shirts, frocks for girls, etc. Once you have gathered what all you need, it’s time to enjoy the efficient services that we have to give you and wait for the latest fashion to grab you at your doorstep! Just make your selection in our fashion store and validate your purchase in a few clicks.
                </p>









            </div>

            <div class="col-lg-3">



            </div>


        </div>

    </div>
    <br>
    <br>
    <br>

    <Footer></Footer>

</div>
</template>
<!--<style>-->
    <!--body-->
    <!--{-->
        <!--background-image: url("../../../public/images/outletinn2021-01-03.jpg");-->
        <!--height: 100%;-->

        <!--/* Center and scale the image nicely */-->
        <!--background-position: center;-->
        <!--background-repeat: no-repeat;-->
        <!--background-size: cover;-->

    <!--}-->
<!--</style>-->
<script>
    import Footer from "../components/Footer";
    export default {
        components: {Footer}
    }
</script>
