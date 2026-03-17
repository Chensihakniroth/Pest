import mongoose from 'mongoose';

const paymentSchema = new mongoose.Schema({
    user_id: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    booking_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Booking', required: true },
    payment_reference: { type: String, required: true, unique: true },
    amount: { type: Number, required: true },
    status: { type: String, enum: ['pending', 'completed', 'failed'], default: 'pending' },
    payment_method: { type: String },
    paid_at: { type: Date }
}, { timestamps: true });

const Payment = mongoose.model('Payment', paymentSchema);
export default Payment;
