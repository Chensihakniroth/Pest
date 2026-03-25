import mongoose from 'mongoose';

const bookingSchema = new mongoose.Schema({
    user: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    flight: { type: mongoose.Schema.Types.ObjectId, ref: 'Flight', required: true },
    booking_reference: { type: String, required: true, unique: true },
    status: { type: String, enum: ['pending', 'pending_payment', 'confirmed', 'cancelled'], default: 'pending' },
    total_price: { type: Number, required: true },
    fare_class: { type: String },
    seat_number: { type: String }
}, { timestamps: true });

const Booking = mongoose.model('Booking', bookingSchema);
export default Booking;
