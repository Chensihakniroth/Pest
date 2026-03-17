import mongoose from 'mongoose';

const passengerSchema = new mongoose.Schema({
    booking_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Booking', required: true },
    first_name: { type: String, required: true },
    last_name: { type: String, required: true },
    date_of_birth: { type: Date },
    passport_number: { type: String },
    seat_number: { type: String }
}, { timestamps: true });

const Passenger = mongoose.model('Passenger', passengerSchema);
export default Passenger;
