<template>
<v-layout row justify-center>
<v-dialog v-model="isDialogOpen" width="600px" persistent>
<v-card>
  <v-toolbar color="blue-grey" dark dense><v-toolbar-title>{{ formTitle }}</v-toolbar-title></v-toolbar>
  <v-card-text pa-2>
    <v-form>
      <h4>Rodzaj szkła</h4>
      <v-layout>
          <v-flex xs12 md5 px-2><v-select label="Materiał" :items="materials" item-text="name"
              item-value="id" prepend-icon="terrain" @change="choosedMaterialId"></v-select></v-flex>
          <v-flex xs12 md4 px-2>
            <v-select label="Typ" :items="materialTypes" item-text="name" prepend-icon="crop_original"
              item-value="id" @change="choosedMaterialTypeId"></v-select></v-flex>
          <v-flex xs12 md3 px-2><v-select :label="'Grubość'" :items="thickness" item-text="name" append-icon="vertical_align_center"></v-select></v-flex>
      </v-layout>
      <h4>Wymiary tafli</h4>
      <v-layout align-center justify-space-around row>
        <v-flex px-3 xs12 md5><v-text-field label="Szerokość" suffix="cm" prepend-icon="code"></v-text-field></v-flex>
        <v-btn flat disabled fab small><v-icon dark>clear</v-icon></v-btn>
        <v-flex px-3 xs12 md5><v-text-field label="Wysokość" suffix="cm" prepend-icon="unfold_more"></v-text-field></v-flex>
      </v-layout>
      <h4>Rodzaj szlifu</h4>
      <v-layout><v-flex xs12>
        <v-select label="Nazwa" prepend-icon="tune" :items="cutModels" item-value="name" item-text="name"></v-select>
      </v-flex></v-layout>

    <v-btn block color="info" dark @click="addHole">DODAJ OTWORY</v-btn>
    <v-card v-if="holes.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="item in holes" :key="item">
      <v-flex px-3 xs5><v-text-field label="Średnica" suffix="mm" prepend-icon="block" :value="item.number"></v-text-field></v-flex>
      <v-flex px-3 xs5><v-text-field label="Ilość" suffix="szt" prepend-icon="filter_none" :value="item.diameter"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteHole(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-1" dark @click="addService">DODAJ USŁUGI</v-btn>
    <v-card v-if="services.length > 0"><v-card-text>
      <v-layout align-start justify-start row v-for="item in services" :key="item">
      <v-flex px-3 xs6><v-select label="Nazwa" :items="servicesList" item-text="name" v-model="item.service_list_id"></v-select></v-flex>
      <v-flex px-3 xs4><v-text-field label="Ilość" :suffix="'szt'" prepend-icon="filter_none" :value="item.quantity"></v-text-field></v-flex>
      <v-flex><v-btn flat fab @click="deleteService(item)"><v-icon>close</v-icon></v-btn></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <v-btn block color="orange darken-4" dark @click="addAdditionalService">DODAJ DODATKOWE USŁUGI</v-btn>
    <v-card v-if="additionalServices.length > 0"><v-card-text>
      <v-layout align-start justify-start row wrap v-for="item in additionalServices" :key="item">
        <v-flex px-3 xs6><v-text-field label="Cena" suffix="zł" :value="item.price" prepend-icon="attach_money"></v-text-field></v-flex>
        <v-flex><v-btn flat fab @click="deleteAdditionalService(item)"><v-icon>close</v-icon></v-btn></v-flex>
        <v-flex px-3 xs12><v-textarea box name="additional-service-body" label="Opis" :value="item.description"></v-textarea></v-flex>
    </v-layout>
    </v-card-text></v-card>

    <h4 class="mt-4">Ilość sztuk tego produktu</h4>
    <v-layout align-center justify-space-around row>
      <v-flex px-3 xs12><v-text-field label="Ilość" suffix="szt" prepend-icon="scatter_plot"></v-text-field></v-flex>
    </v-layout>

    <h2>Cena produktu: {{ totalValueInPennyShowed }} zł</h2>
    <v-btn @click="showWhatIgot">Pokaż jakie zmienne mam</v-btn>
    </v-form>
  </v-card-text>
  <v-card-actions>
    <v-btn color="amber darken-4" flat dark @click="closeDialog">Anuluj</v-btn>
    <v-spacer></v-spacer>
    <v-btn color="green darken-1" dark @click="closeDialog">Zapisz</v-btn>
  </v-card-actions>
</v-card>
</v-dialog>
</v-layout>
</template>
<script>
  export default {
    props: ['obj'],
    data () {return {
      isDialogOpen: false,
      materials: [], materialTypes: [], thickness: [], cutModels: [], holes: [], additionalServices: [], services: [],
      holePrices: [], servicesList: [], glassModels: [],
      totalValueInPennyShowed: 12242,
      choosenMaterialId: null, choosenMaterialTypeId: null,
    }},
    created() {
      this.getMaterials();
      this.getMaterialTypes();
      this.getGlassModels();
      //computed
      this.showAllThickness();
      // this.getCutModels();
      // this.getServicesList();
      // this.getHolePrices();
      this.changeGlassModelThicknessList();
      this.lisen();
    },
    computed: {
      formTitle () {return nd2.isEmpty(this.obj) ? 'Dodaj produkt' : 'Edytuj produkt'},
    },
    methods: {
      lisen(){
        EventBus.$on('openAddGlassPaneDialog', () => {this.isDialogOpen = true;});
        EventBus.$on('closeAddGlassPaneDialog', () => {this.isDialogOpen = false;});
      },
      closeDialog(){EventBus.$emit('closeAddGlassPaneDialog');},
      addHole() {let obj = {number: '', diameter: ''}; this.holes.push(obj);},
      deleteHole(item) {let index = this.holes.indexOf(item); this.holes.splice(index, 1);},
      addService() {let obj = {service_list_id: '', quantity: ''}; this.services.push(obj);},
      deleteService(item) {let index = this.services.indexOf(item); this.services.splice(index, 1);},
      addAdditionalService() {let obj = {price: '', description: ''}; this.additionalServices.push(obj);},
      deleteAdditionalService(item) {let index = this.additionalServices.indexOf(item); this.additionalServices.splice(index, 1);},
      getMaterials() {axios.get('/api/material/all').then(res => this.materials = res.data).catch(e => console.log(e));},
      getMaterialTypes() {axios.get('/api/material-types/all').then(res => this.materialTypes = res.data).catch(e => console.log(e));},
      getCutModels() {axios.get('/api/cut-models/all').then(res => this.cutModels = res.data).catch(e => console.log(e));},
      getGlassModels() {axios.get('/api/glass-models/all').then(res => this.gettedGlassModels(res.data)).catch(e => console.log(e));},
      getHolePrices() {axios.get('/api/hole-prices/all').then(res => this.holePrices = res.data).catch(e => console.log(e));},
      getServicesList() {axios.get('/api/services-list/all').then(res => this.servicesList = res.data).catch(e => console.log(e));},
      showWhatIgot(){
        // console.log(this.materials);
        console.log(this.choosenMaterialId);
        console.log(this.choosenMaterialTypeId);
        // console.log(this.materialTypes);
        // console.log(this.thickness);
        // console.log(this.cutModels);
        // console.log(this.holes);
        // console.log(this.additionalServices);
        // console.log(this.glassModels);
        // console.log(this.services);
        // console.log(this.servicesList);
        // console.log(this.holePrices);
      },
      gettedGlassModels(data) {this.glassModels = data; this.showAllThickness();},
      choosedMaterialId(id){
        this.choosenMaterialId = id;
        this.changeGlassModelThicknessList();
      },
      choosedMaterialTypeId(id){
        this.choosenMaterialTypeId = id;
        this.changeGlassModelThicknessList();
      },
      getMaterialId(index) {
        this.choosenMaterialId = index;
      },
      showAllThickness() {
        let data = this.glassModels.sort((a,b) => a.thickness - b.thickness);
        this.thickness = data.map((item) => {return {name: item.thickness/1000 + ' mm'};});
      },
      changeGlassModelThicknessList() {
        let data = this.glassModels.sort((a,b) => a.thickness - b.thickness);
        let materialId = this.choosenMaterialId;
        let materialTypeId = this.choosenMaterialTypeId;

        this.thickness = data.filter(function(obj) {
          return obj.material_id == materialId;
        }).map(function(obj) {return {name: obj.thickness/1000 + ' mm'}});
        // }).map(function(obj) { return obj.thickness; });

        }
      },
  }
</script>
