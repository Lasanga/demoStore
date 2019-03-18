<template>
  <div>
    <div>
    </div>
    <div v-if="images.length == 0">
      <div class="mt-5">
        <i>Sorry! No images to preview</i>
      </div>
    </div>
    <div
      v-if="images.length > 0"
      id="carouselExampleControls"
      class="carousel slide mt-5"
      data-ride="carousel"
    >
      <div class="carousel-inner">
        <div class="carousel-item" v-for="image in images" v-bind:key="image.id">
          <img
            v-bind:src="`http://localhost/demostore/storage/app/public/productImages/${image.productImage}`"
          >
        </div>
        <div class="carousel-item active">Please click here :)</div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselExampleControls"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselExampleControls"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</template>
<script>
export default {
  name: "images",
  data() {
    return {
      selecteFile: null,
      productToken: "",
      image: {
        productImage: "",
        productId: ""
      },
      images: [],
      path: "http://localhost/demostore/storage/app/public/productImages/"
    };
  },
  created() {
    console.log(this.$route.params.id);
    this.getImages(this.$route.params.id);
  },
  methods: {
    getImages(id) {
      (this.productToken = id),
        axios.get("/image/" + id + "").then(res => {
          this.images = res.data.data;
          console.log(this.images);
        });
    }
  }
};
</script>
