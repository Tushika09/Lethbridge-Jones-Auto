-- CREATE DUMMY DATA --
-- ================================================================================================== --
-- 1 -- vehicle
-- ================================================================================================== --

-- typo vehicle conditon instead of condition
INSERT INTO vehicle (vehicle_id, make, model, year, colour, miles, vehicle_condition, book_price)
VALUES 
	(01, 'ford', 'fiesta', 2022, 'blue', 10000, 'good', 16500.22),
	(02, 'ford', 'f-150', 2016, 'silver', 150962, 'moderate', 18750),
	(03, 'toyota', 'tacoma', 2010, 'beige', 200989, 'poor', 12500);
    

-- ================================================================================================== --
-- 2 -- customer
-- ================================================================================================== --


INSERT INTO customer(customer_id, first_name, last_name, gender, DOB, phone_number, address, city, state, zip)
VALUES
	('0001', 'Andy', 'Anderson', 'M', '1980-01-01', 9999999, '01 Anderson Road', 'Andersville', 'Az', 'AAA111'),
	('0002', 'Barry', 'Barbell', 'F', '1990-01-22', 8888888, '424 Burberry Lane', 'Bonnieville', 'AB', 'BBB222'),
	('0003', 'Charlie', 'Clydesdale', 'M', '2000-12-31', 6666666, 'Farmridge Faust', 'Calgary', 'AB', 'CCC333');
    


-- ================================================================================================== --
-- 3 -- Employee
-- ================================================================================================== --
-- sale insertion
-- For id's, the # of leading 0's indicates which ID it is
-- no leading zeros - vehicle id
-- 0 sale id
-- 00 customer id
-- 000 employee id
-- ================================================================================================== --

INSERT INTO employee(employee_id, first_name, last_name, job_title, phone_number)
VALUES
	(100, 'Billy', 'Billison', 'sales associate', 1111111),
	(200, 'Mange', 'Bosso', 'Manager', 4444444),
	(101, 'Eileen', 'Echo', 'sales associate', 5555555);



-- ================================================================================================== --
-- 4 -- purchase
-- ================================================================================================== --

INSERT INTO purchase(vehicle_id, purchase_date, location, seller, auction, price_paid)
VALUES
	(1, '2023-01-03', 'Brooks', 'private', 1, 1000),
	(2, '2025-11-16', 'Cornwhale', 'Lethbridge VEHC', 1, 2000),
	(3, '2025-07-12', 'Didsburry', 'private', 1, 3000);


    
    
-- ================================================================================================== --
-- 5 -- problem
-- ================================================================================================== --

INSERT INTO problem(problem_type, problem_description, eestimated_repair_cost, actual_repair_cost, vehicle_id)
VALUES
	('exterior', 'Deep scrath on front left door', 750.00, 625.72, 1);

-- ================================================================================================== --
-- 6 -- sale
-- ================================================================================================== --

INSERT INTO sale(sale_id, vehicle_id, customer_id, sale_date, sale_price, down_payment, finance_term_length, interest, commission, employee_id, open_closed)
VALUES
	(1, 1, '0001', '2024-08-09', 18500, 3000, 12, 0.2, 0.12, 100, 'open'),
	(2, 2, '0003', '2026-04-14', 11500, 500, 18, 0.15, 0.12, 101, 'open'),
	(3, 3, '0002', '2026-01-22', 13750, 5000, 24, 0.1, 0.12, 101, 'open');





-- ================================================================================================== --
-- 6 -- warranty
-- ================================================================================================== --

INSERT INTO warranty(warranty_id, start_date, end_date, cost, deductible, sale_id)
VALUES
	(1, '2024-08-09', '2026-08-09', 1000, 500, 1);

-- ================================================================================================== --
-- 6 -- customer_employment_history
-- ================================================================================================== --

INSERT INTO customer_employment_history(employer, job_title, supervisor, customer_id, phone_number, start_date)
VALUES
	('U of L', 'TA', 'John Zhang', '0001', 3333333, '2012-01-01'),
	('Shoppers', 'Cashier', 'Charlotte V', '0002', 2222220, '2015-01-01'),
	('Shoppers', 'Manager', 'Tom Tomlinson', '0002', 2222220, '2018-08-09'),
	('Cowboys Casino', 'Cowboy', 'Long John', '0003', 3333330, '2001-11-11');




-- ================================================================================================== --
-- 7 -- payment
-- ================================================================================================== --
INSERT INTO payment(payment_number, sale_id, due_date, paid_date, amount_due, amount_paid, bank_account)
VALUES 
-- ANDY ANDERSON
    (0, 1, '2024-08-09', '2024-08-09', 3000, 3000, 'abc101def'),
    (1, 1, '2024-09-09', '2024-09-09', 1000, 1000, 'abc101def'),
    (2, 1, '2024-10-09', '2024-10-09', 1000, 1000, 'abc101def'),
-- Barry Barbell
    (0, 3, '2026-01-22', '2026-01-22', 5000, 5000, 'qed202'),
    (1, 3, '2026-02-22', '2026-02-23', 750, 750, 'qed202'),
    (2, 3, '2026-03-22', '2026-03-29', 750, 500, 'qed202'),
-- Charlie Clydesdale
    (0, 2, '2026-04-14', '2026-04-14', 500, 500, 'xyz987'),
    (1, 2, '2026-05-14', '2026-05-14', 1500, 1500, 'xyz987'),
    (2, 2, '2026-06-14', '2026-06-14', 1500, 1500, 'xyz987');


