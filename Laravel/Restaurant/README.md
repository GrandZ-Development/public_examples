# Restaurant

One module from the last project, the essence of which was to write a REST Api for a restaurant using PHP framework Laravel

The essence of the module is the exchange of data for different aspects of the restaurant operation, such as: Working hours, Holiday hours, Floor Management, Item / Slide / Upsells Management, Coupons and Promotions management, Sales Tax Management, Seat and Sections Management, Service fee management, Table Reservation Management

The module used: 
	•	Final classes 
	•	Custom Request classes that extend FormRequest class with different validation rules 
	•	Api resources that allowed us to transform our model and collection into beautiful JSON
	•	Instead of standard Laravel routes, Dingo routes were used
	•	Laravel ORM Eloquent was used to interact with the Mysql database
	•	Apidoc library which allows generate documentation in a beautiful form based on the comments left in the code

For version control, gitlab was used with a configured CI / CD pipeline that allowed run deploy to be performed after pushing to the dev branch
