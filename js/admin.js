Vue.createApp({
    data() {
      return {
          q:'',
          datas: '',
          cars : [],
          drivers : [],
          users : [],
          car: {
              'name' : '',
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
      
      
      car_cls(){
          this.car = {'name' : '', 'act' : 'insert'}
      },
      car_add(){
          this.car_cls()
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
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
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
          }
        })

          
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
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
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
          }
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

  