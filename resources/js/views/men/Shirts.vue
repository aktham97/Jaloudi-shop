<template>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <br>
                <Men_clothing></Men_clothing>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-8">
                <br>
                <br>
                <div class="row">


                    <div class="col-lg-4 col-md-6 mb-4" v-for="(shirt,index) in shirts" :key="index">
                        <div class="card h-100">
                            <a href="#"><img v-on:click="showNewRating(shirt.id)" class="card-img-top"
                                             :src="`${$store.state.servicePath}/storage/${shirt.image}`" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">{{shirt.name}}</a>
                                </h4>
                                <h5 style="color: red">${{shirt.price}}</h5>
                                <p class="card-text">{{shirt.description}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted" v-if="shirt.rating >= 4.5">&#9733; &#9733; &#9733; &#9733;
                                    &#9733;
                                </small>
                                <small class="text-muted" v-if="shirt.rating >= 3.5 && shirt.rating < 4.5">&#9733;
                                    &#9733; &#9733; &#9733; &#9734;
                                </small>
                                <small class="text-muted" v-if="shirt.rating >= 2.5 && shirt.rating < 3.5">&#9733;
                                    &#9733; &#9733; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="shirt.rating >= 1.5 && shirt.rating < 2.5">&#9733;
                                    &#9733; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="shirt.rating >= 0.5 && shirt.rating < 1.5">&#9733;
                                    &#9734; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="shirt.rating < 0.5">&#9734; &#9734; &#9734; &#9734;
                                    &#9734;
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->
            <div class="col-lg-1">
                <br>
                <br>
                <button  type="button" class="btn btn-primary fixed-button" v-on:click="showNewShirt"><span
                    class="fa fa-plus"></span> Add New shirt
                </button>
                <br>
                <br>
                <br>


            </div>
        </div>
        <!-- /.row -->
        <div class="text-center" v-if="moreShirts">
            <button type="button" class="btn btn-primary btn-sm button-arrow-down" v-on:click="loadMoreShirts"><span class="fa fa-arrow-down"></span>Load More</button>
        </div>
        <div>
            <b-modal ref="newShirtModal" hide-footer title="Add New Shirt">
                <div class="d-blockr">
                    <form v-on:submit.prevent="createShirt">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="shirtData.name"
                                   placeholder="Enter name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" v-model="shirtData.price" id="price"
                                   placeholder="price">
                            <div class="invalid-feedback" v-if="errors.price">{{errors.price[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <br>
                            <textarea rows="4" cols="50" id="description" v-model="shirtData.description"></textarea>
                            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
                        </div>
                        <div class="form-check">
                            <label for="image">Image</label>
                            <div v-if="shirtData.image.name">
                                <img src="" ref="newShirtImageDisplay" class="w-150px"/>
                            </div>
                            <input type="file" class="form-control" ref="newShirtImage" v-on:change="attachImage"
                                   id="image">
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewShirt">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>

            <b-modal ref="newRatingModal" hide-footer title="Thank you for rating">
                <div class="d-blockr">
                    <form v-on:submit.prevent="addNewRating">
                        <div class="form-group">
                            <label for="rating">Select your rating</label>
                            <select class="form-control" id="rating" v-model="shirtData.rating">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Very Good</option>
                                <option value="3">Average</option>
                                <option value="2">Poor</option>
                                <option value="1">Terrible</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.rating">{{errors.rating[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewRating">Cancel</button>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>Save</button>
                        </div>
                    </form>
                </div>
            </b-modal>
        </div>
    </div>
</template>
<script>
    import * as shirt_service from '../../services/men/shirt_service';
    import Men_clothing from "../../components/Men_clothing";

    export default {
        name: 'shirts',
        components: {Men_clothing},
        data() {
            return {
                shirts: {},
                shirtData: {
                    name: '',
                    price: '',
                    description: '',
                    rating: '',
                    image: '',
                    id:''
                },
                moreShirts:false,
                nextPage:0,
                errors: {}
            }
        },
        mounted() {
            this.loadShirts();
        },
        methods: {
            loadShirts: async function () {
                try {
                    const response = await shirt_service.loadShirts();
                    console.log(response);
                    this.shirts = response.data.data;
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreShirts = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreShirts = false;
                    }
                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred , Please refresh!',
                        time: 5000
                    });
                }
            },
            loadMoreShirts: async function(){
                try {
                    const response = await shirt_service.loadMoreShirts(this.nextPage);
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreShirts = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreShirts = false;
                    }
                    response.data.data.forEach(data => {
                        this.shirts.push(data);
                    });

                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred during load more shirts , Please refresh!',
                        time: 5000
                    });
                }
            },

            attachImage() {
                this.shirtData.image = this.$refs.newShirtImage.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs.newShirtImageDisplay.src = reader.result;
                }.bind(this), false);
                reader.readAsDataURL(this.shirtData.image);

            },
            hideNewShirt() {
                this.$refs.newShirtModal.hide();

            },
            showNewShirt() {
                this.$refs.newShirtModal.show();

            },
            hideNewRating() {
                this.$refs.newRatingModal.hide();

            },
            showNewRating(id) {
                this.shirtData.id=id;
                this.$refs.newRatingModal.show();

            },
            addNewRating: async function(){
                console.log(this.shirtData.rating,this.shirtData.id);
                let formData = new FormData();
                formData.append('rating', this.shirtData.rating);
                try {
                    const response = await shirt_service.editRating(this.shirtData.id,formData);
                    this.hideNewRating();
                    this.flashMessage.success({
                        message: 'Rating added successfully!',
                        time: 5000
                    });
                    this.shirtData = {
                        id: '',
                        rating: '',
                    };
                }catch (error) {
                    console.log(error);
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
            },
            createShirt: async function () {
                let formData = new FormData();
                formData.append('name', this.shirtData.name);
                formData.append('price', this.shirtData.price);
                formData.append('description', this.shirtData.description);
                formData.append('image', this.shirtData.image);

                try {
                    const response = await shirt_service.createShirt(formData);
                    this.shirts.unshift(response.data);
                    this.hideNewShirt();
                    this.flashMessage.success({
                        message: 'Shirt Stored successfully!',
                        time: 5000
                    });
                    this.shirtData = {
                        name: '',
                        price: '',
                        description: '',
                        image: ''
                    };
                } catch (error) {
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
