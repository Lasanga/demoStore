<template>
  <div class="mt-2">
    <div class="col-12">
      <div class="mt-3">
        <button
          type="button"
          class="btn btn-success"
          data-toggle="modal"
          data-target="#exampleModal"
          data-whatever="@getbootstrap"
        >Add Product</button>

        <div
          class="modal fade"
          id="exampleModal"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="product-name" class="col-form-label">Product Name:</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="product.displayName"
                      id="product-name"
                    >
                  </div>
                  <div class="form-group">
                    <label for="supplier-name" class="col-form-label">Supplier Name:</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="product.supplierName"
                      id="supplier-name"
                    >
                  </div>
                  <div class="form-group">
                    <label for="qty" class="col-form-label">Quantity:</label>
                    <input type="number" class="form-control" v-model="product.quantity" id="qty">
                  </div>
                  <div class="form-group">
                    <label for="price" class="col-form-label">Price:</label>
                    <input type="number" class="form-control" v-model="product.price" id="price">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="addProduct()" class="btn btn-primary">Add</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-8">
          <div class="row">
            <div class="col-sm-4" v-for="product in products" v-bind:key="product.id">
              <div class="card mt-3">
                <div class="card-body">
                  <h5 class="card-title">{{product.displayName}}</h5>
                  <p class="card-text">Supplier: {{product.supplierName}}</p>
                  <p class="card-text">Quantity left: {{product.quantity}}</p>
                  <a @click="gotoImages(product.id)" class="btn btn-block btn-primary">More Details</a>
                  <a @click="addtoCart(product)" class="btn btn-block btn-success mt-2">Add to cart</a>
                  <!-- <div class="clearfix m-1">
                    <button @click="inc()" class="btn btn-success btn-sm m-1">+</button>
                    <button @click="dec()" class="btn btn-danger btn-sm">-</button>
                  </div>-->
                </div>
              </div>
            </div>
          </div>
          <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
              <li class="page-item" v-bind:class="[{disabled: !pagination.prevPage}]">
                <a class="page-link" @click.prevent="getProducts(pagination.prevPage)">Previous</a>
              </li>

              <li class="page-item">
                <a
                  class="page-link"
                  @click.prevent
                >Page {{pagination.currPage}} of {{pagination.lastPage}}</a>
              </li>

              <li class="page-item" v-bind:class="[{disabled: !pagination.nextPage}]">
                <a class="page-link" @click.prevent="getProducts(pagination.nextPage)">Next</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-4">
          <div class="card mt-3">
            <div class="card-header">
              <h4>Cart - {{carts.length}}</h4>
            </div>
            <div class="card-body" style="height:315px; overflow: scroll">
              <ul class="list-group" v-for="cart in carts" v-bind:key="cart.id">
                <li class="list-group-item">
                  <strong>Name</strong>
                  {{cart.name}} -
                  <strong>price</strong>
                  {{cart.price}}
                </li>
              </ul>
            </div>
            <div class="card-footer">
              <i>Cart value: {{total}}</i>
              <hr>
              <button class="btn btn-block btn-success" @click="purchase(carts)">Purchase</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Cart from "./Cart.vue";
export default {
  name: "product",
  components: {
    Cart
  },
  data() {
    return {
      isModalShow: true,
      products: [],
      product: {
        id: "",
        displayName: "",
        supplierName: "",
        quantity: "",
        price: ""
      },
      prodcutId: "",
      pagination: {},
      edit: false,
      carts: [],
      cartAdd: {
        id: "",
        name: "",
        price: 0,
        qty: 0
      },
      cartShow: {
        name: "",
        price: 0,
        qty: 0
      },
      total: 0,
      quantity: 1
    };
  },
  beforeCreate() {
    let token = this.$session.get("accessToken");
    if (token == null) {
      this.$router.push("/singin");
    }
  },
  created() {
    this.getProducts();
    this.showCart();
  },
  methods: {
    showCart() {
      if (localStorage.getItem("cart")) {
        this.carts = JSON.parse(localStorage.getItem("cart"));
        this.total = this.carts.reduce((var1, var2) => {
          return this.total + this.quantity * var2.price;
        }, 0);
      }
    },
    addtoCart(item) {
      this.cartAdd.id = item.id;
      this.cartAdd.name = item.displayName;
      this.cartAdd.price = item.price;
      this.carts.push(this.cartAdd);
      this.cartAdd = {};
      this.storeCart();
    },
    removeCart(item) {
      this.carts.splice(item, 1);
      this.storeCart();
    },
    storeCart() {
      localStorage.setItem("cart", JSON.stringify(this.carts));
      this.showCart();
    },
    getProducts(pageUrl) {
      let vm = this;
      pageUrl = pageUrl || "/products";
      axios
        .get(pageUrl)
        .then(res => {
          this.products = res.data.data;
          vm.paginate(res.data.meta, res.data.links);
        })
        .catch(console.error());
    },
    paginate(meta, links) {
      let paginataion = {
        currPage: meta.current_page,
        lastPage: meta.last_page,
        nextPage: links.next,
        prevPage: links.prev
      };

      this.pagination = paginataion;
    },

    addProduct() {
      let newProduct = {
        displayName: this.product.displayName,
        supplierName: this.product.supplierName,
        quantity: this.product.quantity,
        price: this.product.price
      };

      axios
        .post("product", newProduct)
        .then(res => {
          this.products.push(res.data.data);
          $("#exampleModal").modal("hide");
          $(".modal-backdrop").remove();
        })
        .then(json => {})
        .catch(console.error());
    },
    gotoImages(idd) {
      this.$router.push("/product/" + idd + "");
    },
    purchase(data){
      let newPurchases = [{
        customerName: this.$session.get('username'),
        date: new Date,
        data: data
      }];
      localStorage.setItem('purchases', JSON.stringify(newPurchases));
    }
  }
};
</script>

