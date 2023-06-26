Vue.createApp({
    data() {
      return {
            q:'',
            datas: '',
            cars : [],
            drivers : [],
            car_types : [],
            car: {
                'vehicle_reg' : 'กท 123',
                'province' : 'กทม',
                'car_type_id' : '',
                'act' : 'insert'
            },
            car_type: {
                'car_type_name' : '',
                'act' : 'insert'
            },
            driver: {
                'usr_id' : '',
                'act' : 'insert'
            },            
            isLoading : false,
        }
    },
    mounted(){
        this.get_cars()
        this.get_car_types()
        this.get_drivers()
    },
    watch: {
        q(){
            this.search()
        }
      },
    
    methods: {
        get_cars(){
            this.isLoading = true;
            axios.post('./api/admin/get_cars.php')
            .then(response => {
                this.cars = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
        get_car_types(){
            this.isLoading = true;
            axios.post('./api/admin/get_car_types.php')
            .then(response => {
                this.car_types = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
        get_drivers(){
            this.isLoading = true;
            axios.post('./api/admin/get_drivers.php')
            .then(response => {
                this.drivers = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
       
        search(){
                if(this.q.length > 1 ){
                    this.isLoading = true
                    axios.post('./api/index/get_car_recs.php',{q:this.q})
                    .then(response => {
                        if (response.data.status) {
                            this.datas = response.data                        
                            this.projects = response.data.projects                        
                        } else{
                            this.projects = [
                                
                            ]
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
                }else{
                    this.get_car_recs()
                }
        },
        car_type_cls(){
            this.car_type = {'car_type_name' : '','act' : 'insert'}
        },
        car_type_add(){
            this.car_type_cls()
            this.car_type.act = 'insert'
            this.$refs.car_type_form.click()  
        },
        car_type_delete(id){
            this.isLoading = true;
            const requestData = { car_type: {id: id,'act':'delete'} };
            axios
              .post('./api/admin/car_type_act.php', requestData)
              .then(response => {
                const resp = response.data 
                const icon = 'success'; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 0; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                this.get_car_types()
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },
        car_type_save() {
            this.isLoading = true;
            const requestData = { car_type: this.car_type };
            axios
              .post('./api/admin/car_type_act.php', requestData)
              .then(response => {
                const resp = response.data 
                const icon = 'success'; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 0; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                this.get_car_types()
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },
          

        car_add(){
            this.car_rec.act = 'insert'
            this.get_cars()
            this.get_drivers()
            this.$refs.car_form.click()  
        },



       print(id){
        this.isLoading = true
        axios.post('./api/cert/print.php',{id:id})    
            .then(response => {
                if (response.data.status) {
                    axios.post('./service/mpdf/api/cert/index.php',{
                        data        : response.data.resp,
                        template    : response.data.template,
                        text        : response.data.text[0],
                    }) 
                    .then(response => {
                        url = response.data.url
                        console.log(url)
                        window.open(url,'_blank')
                    })
                }else{
                  this.alert('warning',response.data.message,0)
                } 
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
  
      }, 
     


     
      alert(icon,message,timer=0){
        swal.fire({
          icon: icon,
          title: message,
          showConfirmButton: false,
          timer: timer
        });
      },
    },
  
  }).mount('#admin')

  