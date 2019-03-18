<template>
  <div>
      <ul class="list-group mt-3" v-for="purchase in purchases" v-bind:key="purchase.id">
          <li class="list-group-item active">{{purchase.customerName}}</li>
          <li class="list-group-item active">{{purchase.date}}</li>
          <ul class="list-group"  v-for="item in purchase.data" v-bind:key="item.id">
            <li class="list-group-item">{{item.name}} - $ {{item.price}}</li>
          </ul>
      </ul>
  </div>
</template>

<script>
export default {
  name: "sale",
  data(){
      return{
          purchases: []
      }
  },
  created(){
      this.getPurchases();
  },
  methods:{
      getPurchases(){
          this.purchases = JSON.parse(localStorage.getItem('purchases'));
          console.log(this.purchases);
      }
  }
};
</script>

<style>
</style>
