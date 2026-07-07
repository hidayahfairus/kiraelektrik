# Electricity Bill Calculator

An electricity bill calculation assignment using plain PHP (Vanilla) and Bootstrap 4.

## Implementation:

1. **Input Form**:
   - Accepts Voltage (V), Current (A), and Electricity Rate (sen/kWh).

2. **Validation**:
   - Checks whether all inputs are numeric values.
   - Ensures all values entered are greater than 0.
   - Displays an error alert if invalid input is detected.

3. **Calculations**:
   - Power (kW) = `(Voltage (V) × Current (A)) / 1000`
   - Energy (kWh) = `Power (kW) × Hour`
   - Electricity Rate (RM/kWh) = `Current Rate (sen/kWh) / 100`
   - Total Cost (RM) = `Energy (kWh) × Electricity Rate (RM/kWh)`

4. **Output Table**:
   - Displays energy consumption and total electricity cost calculation from hour 1 until hour 24.

## How to Run:

1. Copy the `kiraelektrik` folder into `xampp/htdocs/`.
2. Open XAMPP Control Panel and start **Apache**.
3. Open a browser and navigate to: http://localhost/kiraelektrik/
