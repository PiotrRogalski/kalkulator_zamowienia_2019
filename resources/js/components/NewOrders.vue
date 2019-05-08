<template>
<v-layout row wrap>
  <v-flex xs12 lg6>
  <v-toolbar color="blue darken-4" dark dense>
    <info-dialog :message="newOrderInfo"></info-dialog>
    <v-toolbar-title>Nowe zamówienie</v-toolbar-title>
  </v-toolbar>
  <v-card class="pa-1">
    <v-card-text>
      <h4>Dane klienta</h4>
      <v-combobox label="Imię i nazwisko" :rules="[() => !!choosenClient || 'To pole jest wymagane']" :items="clients"
        item-text="full_name" counter="50" hide-no-data prepend-icon="account_box" @change="choosedClient"
      ></v-combobox>
      <v-flex class="text-center">
        <p v-if="clientWillBeCreated" class="success--text">Klient zostanie dodany do bazy danych</p>
      </v-flex>

      <v-combobox label="Numer telefonu" return-masked-value mask="### ### ###" counter="11" hide-no-data
        hide-selected prepend-icon="phone" :value="choosenPhoneNumber" @change="choosedPhoneNumber"
      ></v-combobox>

      <v-text-field label="Zaliczka w PLN" type="number" prepend-icon="attach_money" suffix="zł"
        v-model="choosenOrderAdvance" @keyup="choosedOrderAdvance"
      ></v-text-field>

      <h4>Transport</h4>
      <hr>
      <span v-if="allConfigs.length > 0 && allPlaceOfDeliveries.length > 0">
        <v-radio-group v-model="choosenTransportType" row @change="choosedTransportType">
          <v-radio label="Darmowy" value="free-delivery"></v-radio>
          <v-radio label="W mieście" value="city-delivery"></v-radio>
          <v-radio label="Poza miastem" value="outside-city-delivery"></v-radio>
        </v-radio-group>
        <v-combobox v-show="choosenTransportType=='outside-city-delivery'"
          label="Miejscowość" :items="placeOfDeliveries" item-text="name" counter="50" hide-no-data hide-selected
          prepend-icon="location_on" :value="choosenPlaceOfDelivery" @change="choosedPlaceOfDelivery"
        ></v-combobox>
        <v-flex class="text-center">
          <p v-if="typeof choosenPlaceOfDelivery === 'string' && choosenPlaceOfDelivery !== ''" class="success--text">Miejscowość zostanie dodana do bazy danych</p>
        </v-flex>
        <v-text-field v-show="choosenTransportType=='outside-city-delivery'" label="Odległość w Km"
          type="number" prepend-icon="map" suffix="Km" v-model="choosenDistanceInKm" @keyup="choosedDistanceInKm"
        ></v-text-field>
      </span>
      <v-progress-linear v-else :indeterminate="true"></v-progress-linear>
      <v-flex xs12 lg6>
      <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :nudge-right="40" lazy
        transition="scale-transition" offset-y full-width max-width="290px" min-width="290px">
        <template v-slot:activator="{ on }">
          <v-text-field label="Ostateczny termin realizacji" v-model="dateFormatted" persistent-hint
            prepend-icon="event" @blur="date = parseDate(dateFormatted)" v-on="on"
          ></v-text-field>
        </template>
      <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
      </v-menu>

      </v-flex>
      <hr>

      <h4>Promocje</h4>
      <p>Łączna kwota zamówień klienta to xx xxx zł </br> Ostatnie zamówienie opiewało na kwotę xxx zł </p>
        <v-layout wrap>
          <v-flex xs12 md6><v-text-field label="Rabat w %" v-model="getPercentDiscount"></v-text-field></v-flex>
          <v-flex xs12 md6><v-text-field label="Rabat w PLN" suffix="zł" v-model="getMoneyDiscount"></v-text-field></v-flex>
        </v-layout>
      <hr>

      <h1>Razem: {{ totalValueInPennyShowed/100 }}zł </h1>
      <p class="grey--text">Jeśli chcesz wydrukować to zamówienie jeszcze raz po prostu kliknij zatwierdź</p>
      <v-card-actions>
        <v-btn  color="blue-grey" dark @click="openGlassPaneDialog">DODAJ PRODUKT</v-btn>
        <v-layout align-center justify-end><v-btn color="success" @click="storeNewOrder">Zatwierdź</v-btn></v-layout>
      </v-card-actions>
    </v-card-text>
  </v-card>
  </v-flex>

  <glass-pane-dialog></glass-pane-dialog>
  <!--PRAWA STRONA-->
  <v-flex xs12 lg6>
  <v-toolbar color="indigo" dark dense>
    <info-dialog :message="paneSectionInfo"></info-dialog>
    <v-toolbar-title>Tafle szkła</v-toolbar-title>
  </v-toolbar>
    <v-btn block color="blue-grey" dark @click="openGlassPaneDialog">DODAJ PRODUKT</v-btn>
    <v-data-table :headers="headers" :items="products" :expand="expand" class="elevation-1"
      hide-actions item-key="index" :rows-per-page-items="rowsPerPageItems" :pagination.sync="pagination">
      <template v-slot:items="props">
        <tr @click="props.expanded = !props.expanded">
          <td><b>{{ props.item.glass_model_name }}</b></td>
          <td class="text-xs-right">{{ props.item.quantity }} szt</td>
          <td class="text-xs-right">{{ Math.round(props.item.price,2)/100 }} zł</td>
          <td class="justify-center layout px-0">
            <v-icon class="mr-2 mt-2" @click="editItem(props.item)">edit</v-icon>
            <v-icon class="mt-2" @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </tr>
      </template>
      <template v-slot:no-data>
          <p class="text-xs-center success--text">Użyj przycisku dodaj produkt aby wstawić produkty do zamówienia</p>
      </template>
      <template v-slot:no-results>
        <p class="text-xs-center success--text">Brak produktów - użyj przycisk dodaj produkt</p>
      </template>
      <template v-slot:expand="props">
        <v-card flat>
          <v-card-text>
            <v-layout>
              <v-flex xs12 md6> Szlif: {{ props.item.cut_model_name }}</v-flex>
              <v-flex xs12 md6> Wymiary: {{props.item.width}} x {{props.item.height}} {{props.item.unitGlassPaneDimension}}</v-flex>
            </v-layout>
          </v-card-text>
        </v-card>
      </template>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
    </div>
  </v-flex>
</v-layout>
</template>




<script>
  import InfoDialog from './helpers/InfoDialog';
  import ErrorDialog from './helpers/ErrorDialog';
  import GlassPaneDialog from './helpers/GlassPaneDialog';

  export default {
    components: {InfoDialog, GlassPaneDialog, ErrorDialog},
    data: () => ({
      expand: false, isAddGlassPaneOpen: false, menu1: false, clientWillBeCreated: false,
      rowsPerPageItems: [10, 20, 30, 40], pagination: { rowsPerPage: 10},
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: nd2.formatDate(new Date().toISOString().substr(0, 10)),
      model: null,
      percentDiscount: 0, moneyDiscount: 0, totalValueInPenny: 0, totalValueInPennyShowed: 0, totalValueShowed: 0,
      newOrderInfo: 'W tej sekcji uzupełnia się informacje dotyczące konkretnego zlecenia. Jedyne wymagane pole do uzupełnienia to imię i nazwisko klienta',
      paneSectionInfo: 'To jest miejsce na produkty dotyczące tego zlecenia. Prdukty po dodaniu można wciąż swobodnie zmieniać i edytować a nawet usuwać.',
      confirmDeleteMessage: 'Na pewno chcesz usunąć ten produkt ze zlecenia?',
      headers: [
        {text: 'Nazwa', value: 'glass_model_name', align: 'left'},
        {text: 'Ilość', value: 'quantity'},
        {text: 'Cena', value: 'price'},
        {text: 'Akcje', value: 'glass_model_id', sortable: false}
      ],
      productCurrentIndex: 0,
      products: [
        {index:0,price:1942.32,cut_model_id: 0,quantity:1,cut_model_name: "Brak",glass_model_id: 1,glass_model_name:"szkło 3mm",width:123,height:23,holes:[],services:[],additionalServices:[]},
        {index:1,price:3244,cut_model_id: 0,quantity:1,cut_model_name: "Brak",glass_model_id: 1,glass_model_name:"szkło testowe",width:123,height:23,holes:[],services:[
          {name: 'wycięcie uszy misia',price:7500,quantity: 1,service_list_id: 2,unit: 'szt'},
          {name: '"roboczogodzina"',price:10000,quantity: 1,service_list_id: 5,unit: 'szt'},
        ],additionalServices:[{description:'asd', price:21}]},
        ],
      // products: [],
      clients: [], placeOfDeliveries: [],
      allPlaceOfDeliveries: [], allClients: [], allConfigs: [],
      choosenPlaceOfDelivery: {}, choosenClient: {}, choosenPhoneNumber: '', choosenTransportType: 'free-delivery',
      choosenDistanceInKm: 0, choosenOrderAdvance: 0,
      conf: {},
    }),
    created() {
      this.getAllClients();
      this.getAllPlaceOfDeliveries();
      this.getAllConfigs();
      this.countOrderPrice();
      this.lisen();
    },
    computed: {
      computedDateFormatted() {return nd2.formatDate(this.date)},
      getPercentDiscount: {
        get: function(){
          let total = this.totalValueInPenny;
          let result = (total - (total * this.percentDiscount / 100));
          this.totalValueInPennyShowed = Math.round(result);

          return this.percentDiscount;
        },
        set: function(perc) {
          let validperc = perc;
          let result = (this.totalValueInPenny * validperc) / 100;
          this.moneyDiscount = (Math.round(result)/100).toFixed(2);

          this.countOrderPrice();
        },
      },
      getMoneyDiscount: {
        get: function(){
          this.totalValueInPennyShowed = Math.round(this.totalValueInPenny - this.moneyDiscount*100);

          return this.moneyDiscount;
        },
        set: function(money) {
          let validmoney = money*100;
          let total  = nd2.validNumber(this.totalValueInPenny, 1,1, true);
          let result = (validmoney * 100) / total;
          this.percentDiscount = result.toFixed(2);

          this.countOrderPrice();
        },
      },
      pages () {
        if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null) return 0;
        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      },
    },
    watch: {date (val) {this.dateFormatted = nd2.formatDate(this.date)},dialog (val) {val || this.close()},},

    methods: {
      openGlassPaneDialog() {nd2.openGlassPaneDialog();},
      closeGlassPaneDialog() {nd2.closeGlassPaneDialog(); this.countOrderPrice();},
      parseDate(date){return nd2.parseDate(date)},
      lisen() {
        EventBus.$on('addGlassPaneToProductsList', (obj) => {this.addProduct(obj);});
      },
      editItem (item) {EventBus.$emit('openToEditGlassPaneDialog', item); this.openGlassPaneDialog();},
      deleteItem (item) {const index = this.products.indexOf(item); confirm(this.confirmDeleteMessage) && this.products.splice(index, 1); this.countOrderPrice();},
      close () {this.closeGlassPaneDialog();},
      addProduct(obj) {
        // add new or else update product
        if ((typeof(obj.index) === "undefined") || (obj.index === -1)) {
          obj.index = this.productCurrentIndex;
          this.productCurrentIndex++;
          this.products.push(obj);
        } else {
          this.products.splice(obj.index, 1, obj);
        }
        this.countOrderPrice();
      },
      //get from database
      getAllClients() {axios.get('/api/clients/all').then(res =>  this.gettedAllClients(res.data)).catch(e => console.log(e));},
      getAllConfigs() {axios.get('/api/configs/all').then(res =>  this.gettedAllConfigs(res.data)).catch(e => console.log(e));},
      getAllPlaceOfDeliveries() {axios.get('/api/places-of-deliveries/all').then(res =>  this.gettedAllPlaceOfDeliveries(res.data)).catch(e => console.log(e));},
      //when getted from database
      gettedAllClients(res){
        let defaultObj = [{id: -1, full_name: 'Brak'}];
        if(res !== null && res.length >0){
          this.allClients = res;
        } else {
          this.allClients = defaultObj;
        }
        this.clients = this.allClients;
      },
      gettedAllConfigs(res) {this.allConfigs = res; this.setConfig(); },
      gettedAllPlaceOfDeliveries(res) {
        this.allPlaceOfDeliveries = res;
        this.setAllPlacesOfDelivery();
      },
      //when choosed from inputs
      choosedClient(obj) {
        if (typeof(obj) === 'string'){ this.createNewClient(obj); } else {this.choosenClient = obj;}
        this.changePhoneNumber();
        this.changePlaceOfDeliveries();
      },
      choosedPhoneNumber(val){
        this.choosenPhoneNumber = val;
        if (this.newClientExist()){this.allClients[0].phone_number = val}
      },
      choosedOrderAdvance(){this.countOrderPrice();},
      choosedTransportType(){this.countOrderPrice();},
      choosedPlaceOfDelivery(obj){
        this.choosenPlaceOfDelivery = obj;
        if (this.newClientExist()){
          this.allClients[0].place_of_delivery_id = nd2.validNumber(obj.id);
        }
        this.changeDistanceInKm();
        this.countOrderPrice();
      },
      choosedDistanceInKm() {
        if (this.newClientExist()){this.allClients[0].default_distance = this.choosenDistanceInKm}
        this.countOrderPrice();
      },
      //change the value of (recount)
      changePhoneNumber(){
        let clientNumber = '';
        let setNumber = '';
        if (this.choosenClient !== null) {clientNumber = this.choosenClient.phone_number;}
        if (this.newClientExist()){setNumber = this.allClients[0].phone_number}
        if (clientNumber){setNumber = clientNumber;}
        this.choosenPhoneNumber = setNumber;
      },
      changeDistanceInKm(){
        let distance = 0;
        if (!nd2.empty(this.choosenPlaceOfDelivery) && !nd2.empty(this.choosenPlaceOfDelivery)) {
          distance = nd2.validNumber(this.choosenPlaceOfDelivery.distance);
        }
        this.choosenDistanceInKm = distance;
      },
      changePlaceOfDeliveries() {
        let data = this.allPlaceOfDeliveries.sort((a,b) => a.name - b.name);
        let client = this.choosenClient;
        let rows = [];
        let row = {};

        if (!nd2.empty(client)) {
          rows = data.filter(function(obj) {
            let exactIdMath = (obj.id*1 === client.place_of_delivery_id*1);
            let isNull = (client.place_of_delivery_id === null);
            let validRow = (exactIdMath || isNull);
            return validRow;
          }).map(function(obj) {return obj});
          row = rows[0];

          this.choosenPlaceOfDelivery = row;
          this.changeDistanceInKm();
        }
      },
      //set some value to other
      setAllPlacesOfDelivery() {
        let obj = {id: 0, name: 'Brak', distance: 0};
        this.allPlaceOfDeliveries.unshift(obj);
        this.placeOfDeliveries = this.allPlaceOfDeliveries;
        this.choosenPlaceOfDelivery = this.allPlaceOfDeliveries[0];
      },
      createNewClient(name){
        if (name !==  '') {
          let newClient = {id: 0, phone_number: null, place_of_delivery_id: null, default_distance: null};
          newClient.full_name = name;
          if (!this.newClientExist()){this.allClients.unshift({});}
          //anyway create new client or update it on place 0 in allClients array
          this.allClients.splice(0, 1, newClient);
          this.choosenClient = newClient;
        } else {
          // if we dont named our client or choose one
          this.choosenClient = null;
        }
      },
      newClientExist() {
        let newClientExist = !((this.allClients.length > 0) && (this.allClients[0].id !== 0));
        let choosedNewClientId = false;
        if (!nd2.empty(this.choosenClient)) {choosedNewClientId = (this.choosenClient.id === 0)}
        this.clientWillBeCreated = (newClientExist && choosedNewClientId && !nd2.empty(this.allClients[0]));
        return newClientExist;
      },
      countOrderPrice() {
        let price = 0;
        let advancePrice = 0;
        let distancePrice = 0;
        let productsPrice = 0;
        let products = this.products;

        advancePrice = this.countOrderAdvancePrice();
        distancePrice = this.countDistancePrice();
        for (let i in products) {
          productsPrice += nd2.validNumber(products[i].price);
        }
        price =  Math.round(distancePrice - advancePrice + productsPrice);

        this.totalValueInPenny = price;
      },
      countOrderAdvancePrice(){return nd2.validNumber(this.choosenOrderAdvance) * 100;},
      countDistancePrice(){
        let priceInPenny = 0;
        let distancePrice = 0;
        let oneKmPrice = 0;
        let type = this.choosenTransportType;
        let distance = nd2.validNumber(this.choosenDistanceInKm);
        let totalValueInPenny = nd2.validNumber(this.totalValueInPenny);
        let freeDeliveryFromPrice = nd2.validNumber(this.conf.free_delivery_from_price);
        let freeDeliveryDistance = nd2.validNumber(this.conf.free_delivery_distance);
        let distanceKmPrice = nd2.validNumber(this.conf.distance_km_price);
        let departureCost = nd2.validNumber(this.conf.departure_for_delivery_penny_cost);

        let deliveryFromPriceIsFree = (totalValueInPenny >= freeDeliveryFromPrice) && (freeDeliveryFromPrice !== 0);
        let deliveryDistanceIsFree = (distance <= freeDeliveryDistance) && (freeDeliveryDistance !== 0);

        switch (type) {
          case 'city-delivery': priceInPenny = departureCost; break;
          case 'outside-city-delivery': priceInPenny = departureCost; oneKmPrice = distanceKmPrice;
            if (deliveryDistanceIsFree) {oneKmPrice = 0;} else {distance -= freeDeliveryDistance} break;
          default: priceInPenny = 0;
        }

        distancePrice = (oneKmPrice * distance);
        priceInPenny += distancePrice;
        if (deliveryFromPriceIsFree) priceInPenny = 0;

        return priceInPenny;
      },
      getConfig(value) {
        let data = this.allConfigs;
        let rows = [];
        let row = {};

        rows = data.filter(function(obj) {
          let math = (obj.variable_name === value);
          return math;
        }).map(function(obj) {return obj});
        row = rows[0];

        return row;
      },
      setConfig() {
        let conf = {};
        conf.free_delivery_from_price = this.getConfig('free_delivery_from_price').value;
        conf.free_delivery_distance = this.getConfig('free_delivery_distance').value;
        conf.distance_km_price = this.getConfig('distance_km_price').value;
        conf.departure_for_delivery_penny_cost = this.getConfig('departure_for_delivery_penny_cost').value;
        this.conf = conf;
      },
      isOrderValid() {
        //validate all data print or save
        nd2.showErrorDialog('Houston mamy problem');
        // nd2.showErrorDialog({'hah':['trzy no ico Ty', 'cztery co ja']});
        console.log('isOrderValid');

      },
      storeNewOrder() {
        // this.isOrderValid();
        console.log('storeNewOrder');

        let choosedNewPlaceOfDelivery = typeof choosenPlaceOfDelivery === 'string' && choosenPlaceOfDelivery !== '';
        if (choosedNewPlaceOfDelivery){
          // store miejscowość to db (this.choosenPlaceOfDelivery to nazwa miejscowości w tym przypadku)
        }
      },
    },
  }
</script>
