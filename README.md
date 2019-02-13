# Database-API
Values that need to be in single quotes in a query need to be in single quotes in the URL.

The database has 3 tables: Puppies, Customers, and Posts.
The columns in Puppies are Name, Age, Breed, Location, Immunization_records, Photos, and ID.
The columns in Customers are cid, Customer, and puppy_id.
The columns in Posts are id, puppy_id, time, and date.

Delete example:
http://192.168.50.102/delete.php?user=employeeadmin&secretkey=321456&table=Puppies&conditions=id=%2712%27
Read example:
http://192.168.50.102/read.php?user=employee&secretkey=123654&table=Puppies&order=Age&conditions=Age%20BETWEEN%20%270%27%20AND%20%275%27
Update example:
http://192.168.50.102/update.php?user=employee&secretkey=123654&table=Puppies&set=Name=%27Phil%27&conditions=id=%2717%27
Insert example:
http://192.168.50.102/insert.php?user=employee&secretkey=123654&table=Puppies&columns=Name,Age,Breed,Location,Immunization_records,Photos&values=Green,3,Foodie,Mars,No,No
