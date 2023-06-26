Vue.createApp({
    data() {
      return {
            q:'',
            datas: '',
            cars : [],
            drivers : [],
            car_types : [],
            users : [],
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
                'user_id' : '',
                'act' : 'insert'
            },            
            isLoading : false,
        }
    },
    mounted(){
        this.get_cars()
        this.get_car_types()
        this.get_drivers()
        this.get_users()
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
        get_users(){
            this.isLoading = true;
            axios.post('./api/admin/get_users.php')
            .then(response => {
                this.users = response.data.data
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        }, 
       
        car_type_cls(){
            this.car_type = {'car_type_name' : '','act' : 'insert'}
        },
        car_type_add(){
            this.car_type_cls()
            this.car_type.act = 'insert'
            this.$refs.car_type_form.click()  
        },
        car_type_update(index){
            this.car_type = this.car_types[index]
            this.car_type.act = 'update'
            this.$refs.car_type_form.click()  
        },
        car_type_delete(index){
            this.isLoading = true;
            this.car_type = this.car_types[index]
            this.car_type.act = 'delete' 
            const requestData = { car_type: this.car_type};
            axios
              .post('./api/admin/car_type_act.php', requestData)
              .then(response => {
                const resp = response.data 
                
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
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
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer =3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                if(resp.status == 'success'){
                    this.$refs.btn_car_type_close.click() 
                    this.car_type_cls()
                    this.get_car_types()
                }
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },
          

        car_cls(){
            this.car = {'vehicle_reg' : '', 'province' : '', 'car_type_id' : '','act' : 'insert'}
        },
        car_add(){
            this.car_cls()
            this.get_car_types()
            this.$refs.car_form.click()  
        },
        car_update(index){
            this.car = this.cars[index]
            this.car.act = 'update'
            this.$refs.car_form.click()  
        },
        car_save() {
            this.isLoading = true;
            const requestData = { car: this.car };
            axios
              .post('./api/admin/car_act.php', requestData)
              .then(response => {
                const resp = response.data 
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer =3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                if(resp.status == 'success'){
                    this.$refs.btn_car_close.click() 
                    this.car_cls()
                    this.get_cars()
                }
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },
        car_delete(index){
            this.isLoading = true;
            this.car = this.cars[index]
            this.car.act = 'delete' 
            const requestData = { car: this.car};
            axios
              .post('./api/admin/car_act.php', requestData)
              .then(response => {
                const resp = response.data 
                
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);                    
                if(resp.status == 'success'){

                    this.get_cars()
                }
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },


        driver_cls(){
            this.driver = {'user_id' : '','act' : 'insert'}
        },
        driver_add(){
            this.driver_cls()
            this.get_users()
            this.$refs.driver_form.click()  
        },
        driver_update(index){
            this.driver = this.drivers[index]
            this.driver.act = 'update'
            this.$refs.driver_form.click()  
        },
        driver_save() {
            this.isLoading = true;
            const requestData = { driver: this.driver };
            axios
              .post('./api/admin/driver_act.php', requestData)
              .then(response => {
                const resp = response.data 
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer =3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);
                if(resp.status == 'success'){
                    this.$refs.btn_driver_close.click() 
                    this.driver_cls()
                    this.get_drivers()
                }
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
        },
        driver_delete(index){
            this.isLoading = true;
            this.driver = this.drivers[index]
            this.driver.act = 'delete' 
            const requestData = { driver: this.driver};
            axios
              .post('./api/admin/driver_act.php', requestData)
              .then(response => {
                const resp = response.data 
                
                const icon = resp.status; // กำหนดไอคอนที่ต้องการแสดงใน alert
                const message = resp.message; // กำหนดข้อความที่ต้องการแสดงใน alert
                const timer = 3000; // กำหนดเวลาในการแสดง alert (0 = ไม่มีการปิดอัตโนมัติ)
                this.alert(icon, message, timer);                    
                if(resp.status == 'success'){

                    this.get_drivers()
                }
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.isLoading = false;
              });
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
        //   showConfirmButton: false,
          timer: timer
        });
      },
    },
  
  }).mount('#admin')

  