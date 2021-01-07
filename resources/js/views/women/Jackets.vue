<template>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <br>
                <Women_clothing></Women_clothing>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-8">
                <br>
                <br>
                <div class="row">


                    <div class="col-lg-4 col-md-6 mb-4" v-for="(jacket,index) in jackets" :key="index">
                        <div class="card h-100">
                            <a href="#"><img v-on:click="showNewRating(jacket.id)" class="card-img-top"
                                             :src="`${$store.state.servicePath}/storage/${jacket.image}`" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">{{jacket.name}}</a>
                                </h4>
                                <h5 style="color: red">${{jacket.price}}</h5>
                                <p class="card-text">{{jacket.description}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted" v-if="jacket.rating >= 4.5">&#9733; &#9733; &#9733; &#9733;
                                    &#9733;
                                </small>
                                <small class="text-muted" v-if="jacket.rating >= 3.5 && jacket.rating <= 4.5">&#9733;
                                    &#9733; &#9733; &#9733; &#9734;
                                </small>
                                <small class="text-muted" v-if="jacket.rating >= 2.5 && jacket.rating <= 3.5">&#9733;
                                    &#9733; &#9733; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="jacket.rating >= 1.5 && jacket.rating <= 2.5">&#9733;
                                    &#9733; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="jacket.rating >= 0.5 && jacket.rating <= 1.5">&#9733;
                                    &#9734; &#9734; &#9734; &#9734;
                                </small>
                                <small class="text-muted" v-if="jacket.rating < 0.5">&#9734; &#9734; &#9734; &#9734;
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
                <button  type="button" class="btn btn-primary fixed-button" v-on:click="showNewJacket"><span
                    class="fa fa-plus"></span> Add New jacket
                </button>

            </div>
        </div>
        <!-- /.row -->
        <div class="text-center" v-if="moreJackets">
            <button type="button" class="btn btn-primary btn-sm button-arrow-down" v-on:click="loadMoreJackets"><span class="fa fa-arrow-down"></span> Load More</button>
        </div>

        <div>
            <b-modal ref="newJacketModal" hide-footer title="Add New jacket">
                <div class="d-blockr">
                    <form v-on:submit.prevent="createJacket">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="jacketData.name"
                                   placeholder="Enter name">
                            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" v-model="jacketData.price" id="price"
                                   placeholder="price">
                            <div class="invalid-feedback" v-if="errors.price">{{errors.price[0]}}</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <br>
                            <textarea rows="4" cols="50" id="description" v-model="jacketData.description"></textarea>
                            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
                        </div>
                        <div class="form-check">
                            <label for="image">Image</label>
                            <div v-if="jacketData.image.name">
                                <img src="" ref="newJacketImageDisplay" class="w-150px"/>
                            </div>
                            <input type="file" class="form-control" ref="newJacketImage" v-on:change="attachImage"
                                   id="image">
                            <div class="invalid-feedback" v-if="errors.image">{{errors.image[0]}}</div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" v-on:click="hideNewJacket">Cancel</button>
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
                            <select class="form-control" id="rating" v-model="jacketData.rating">
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
    import * as jacket_service from '../../services/women/jacket_service';
    import Women_clothing from "../../components/Women_clothing";

    export default {

        name: 'jackets',
        components: {Women_clothing},
        data() {
            return {
                jackets: {},
                jacketData: {
                    name: '',
                    price: '',
                    description: '',
                    rating: '',
                    image: '',
                    id: ''
                },
                moreJackets:false,
                nextPage:0,
                errors: {}
            }
        },
        mounted() {
            this.loadJackets();
        },
        methods: {
            loadJackets: async function () {
                try {
                    const response = await jacket_service.loadJackets();
                    console.log(response.data.data);
                    this.jackets = response.data.data;
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreJackets = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreJackets = false;
                    }
                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred , Please refresh!',
                        time: 5000
                    });
                }
            },
            loadMoreJackets: async function(){
                try {
                    const response = await jacket_service.loadMoreJackets(this.nextPage);
                    if (response.data.current_page < response.data.last_page)
                    {
                        this.moreJackets = true;
                        this.nextPage = response.data.current_page + 1;
                    }
                    else
                    {
                        this.moreJackets = false;
                    }
                    response.data.data.forEach(data => {
                        this.jackets.push(data);
                    });

                } catch (err) {
                    this.flashMessage.error({
                        message: 'Some error occurred during load more jackets , Please refresh!',
                        time: 5000
                    });
                }
            },

            attachImage() {
                this.jacketData.image = this.$refs.newJacketImage.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs.newJacketImageDisplay.src = reader.result;
                }.bind(this), false);
                reader.readAsDataURL(this.jacketData.image);

            },
            hideNewJacket() {
                this.$refs.newJacketModal.hide();

            },
            showNewJacket() {
                this.$refs.newJacketModal.show();

            },
            hideNewRating() {
                this.$refs.newRatingModal.hide();

            },
            showNewRating(id) {
                this.jacketData.id=id;
                this.$refs.newRatingModal.show();

            },
            addNewRating: async function(){
                let formData = new FormData();
                formData.append('rating', this.jacketData.rating);
                try {
                    const response = await jacket_service.editRating(this.jacketData.id,formData);
                    this.hideNewRating();
                    this.flashMessage.success({
                        message: 'Rating added successfully!',
                        time: 5000
                    });
                    this.jacketData = {
                        id: '',
                        rating: '',
                    };
                }catch (error) {
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
            createJacket: async function () {
                let formData = new FormData();
                formData.append('name', this.jacketData.name);
                formData.append('price', this.jacketData.price);
                formData.append('description', this.jacketData.description);
                formData.append('image', this.jacketData.image);

                try {
                    const response = await jacket_service.createJacket(formData);
                    this.jackets.unshift(response.data);
                    this.hideNewJacket();
                    this.flashMessage.success({
                        message: 'Jacket Stored successfully!',
                        time: 5000
                    });
                    this.jacketData = {
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
