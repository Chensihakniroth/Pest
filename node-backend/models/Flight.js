import mongoose from 'mongoose';

const flightSchema = new mongoose.Schema({
    flight_number: { type: String, required: true, unique: true },
    origin_airport_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Airport', required: true },
    destination_airport_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Airport', required: true },
    departure_time: { type: Date, required: true },
    arrival_time: { type: Date, required: true },
    price: { type: Number, required: true },
    airline: { type: String, required: true },
    capacity: { type: Number, required: true }
}, { timestamps: true });

const Flight = mongoose.model('Flight', flightSchema);
export default Flight;
