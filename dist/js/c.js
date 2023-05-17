var state_arr = new Array('Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli', 'Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu', 'Jharkhand', 'Karnataka', 'Kashmir', 'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttarakhand', 'Uttar Pradesh', 'West Bengal');

var s_a new Array();
s_a[0]='';
s_a[1]='Adilabad | Anantapur | Chittoor | Kakinada | Guntur | Hyderabad | Karimnagar | Khammam | Krishna | Kurnool | Mahbubnagar | Medak | Nalgonda | Nizamabad | Ongole | Hyderabad | Srikakulam | Nellore | Visakhapatnam | Vizianagaram | Warangal | Eluru | Kadapa';
s_a[2]='Anjaw | Changlang | East Siang | Kurung Kumey | Lohit | Lower Dibang Valley | Lower Subansiri | Papum Pare | Tawang | Tirap | Dibang Valley | Upper Siang | Upper Subansiri | West Kameng | West Siang';


function print_state(state_id){
	var option_str = document.getElementById(state_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select State', '');
	option_str.selectedIndex = 0;
	for (var i=0; i<state_arr.length; i++){
		option_str.options[option_str.length] = new Option(state_arr[i], state_arr[i], state_arr[i]);
	}
}

function print_city(city_id, city_index){
	var option_str = document.getElementById(city_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select City', '');
	option_str.selectedIndex = 0;
	var city_arr = s_a[city_index].split('|');
	for (var i=0; i<city_arr.length; i++){
		option_str.options[option_str.length] = new Option(city_arr[i], city_arr[i]);
	}
}