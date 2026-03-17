import express from 'express';
import mongoose from 'mongoose';
import dotenv from 'dotenv';
import cors from 'cors';
import bodyParser from 'body-parser';
import cookieParser from 'cookie-parser';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

dotenv.config({ path: path.join(__dirname, '../.env') });

import User from './models/User.js';
import Flight from './models/Flight.js';
import Airport from './models/Airport.js';
import Booking from './models/Booking.js';
import Passenger from './models/Passenger.js';

const app = express();
const PORT = 3000;

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(cookieParser());

// Request Logger
app.use((req, res, next) => {
    console.log(`[${new Date().toLocaleTimeString()}] ${req.method} → ${req.url}`);
    next();
});

const DB_NAME = process.env.DB_DATABASE || 'laravelsu15';
mongoose.connect(process.env.MONGO_URL || 'mongodb://localhost:27017', { dbName: DB_NAME })
    .then(() => console.log(`✅ Brain connected to: ${mongoose.connection.name}`))
    .catch(err => console.error('❌ DB Error:', err));

// --- THE COMPLETE MASTER CRUD API ---

// AIRPORTS [GET]
app.get('/api/airports', async (req, res) => {
    const airports = await Airport.find().sort({ city: 1 });
    res.json(airports);
});

// FLIGHTS [GET, INSERT, UPDATE, DELETE]
app.get('/api/flights', async (req, res) => {
    const flights = await Flight.find().populate('origin_airport_id').populate('destination_airport_id').sort({ createdAt: -1 });
    res.json(flights);
});

app.post('/api/flights', async (req, res) => {
    try {
        const flight = new Flight(req.body);
        await flight.save();
        res.json({ success: true, flight });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.get('/api/flights/:id', async (req, res) => {
    const flight = await Flight.findById(req.params.id).populate('origin_airport_id').populate('destination_airport_id');
    res.json(flight);
});

app.put('/api/flights/:id', async (req, res) => {
    try {
        const flight = await Flight.findByIdAndUpdate(req.params.id, req.body, { new: true });
        res.json({ success: true, flight });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.delete('/api/flights/:id', async (req, res) => {
    await Flight.findByIdAndDelete(req.params.id);
    res.json({ success: true });
});

// USERS [GET, INSERT, UPDATE, DELETE]
app.get('/api/users', async (req, res) => {
    const users = await User.find().sort({ createdAt: -1 });
    res.json(users);
});

app.post('/api/users', async (req, res) => {
    try {
        const user = new User(req.body);
        await user.save();
        res.json({ success: true, user });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.put('/api/users/:id', async (req, res) => {
    try {
        const user = await User.findByIdAndUpdate(req.params.id, req.body, { new: true });
        res.json({ success: true, user });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.delete('/api/users/:id', async (req, res) => {
    await User.findByIdAndDelete(req.params.id);
    res.json({ success: true });
});

app.post('/api/users/:id/toggle-restriction', async (req, res) => {
    const user = await User.findById(req.params.id);
    if (user) { user.is_active = !user.is_active; await user.save(); }
    res.json({ success: !!user, is_active: user?.is_active });
});

// BOOKINGS [GET, INSERT, UPDATE, DELETE]
app.get('/api/bookings', async (req, res) => {
    const bookings = await Booking.find().populate('user').populate('flight').sort({ createdAt: -1 });
    res.json(bookings);
});

app.get('/api/bookings/:id', async (req, res) => {
    try {
        const booking = await Booking.findById(req.params.id).populate('user').populate({path: 'flight', populate: ['origin_airport_id', 'destination_airport_id']});
        const passengers = await Passenger.find({ booking_id: req.params.id });
        res.json({ success: true, booking, passengers });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.post('/api/bookings', async (req, res) => {
    try {
        const { user_id, flight_id, total_price, passengers } = req.body;
        const booking = new Booking({ user: user_id, flight: flight_id, booking_reference: 'SC-' + Math.random().toString(36).substring(2, 9).toUpperCase(), status: 'confirmed', total_price });
        await booking.save();
        for (const p of passengers) {
            const passenger = new Passenger({ booking_id: booking._id, first_name: p.first_name, last_name: p.last_name, passport_number: p.passport_number });
            await passenger.save();
        }
        res.json({ success: true, booking_reference: booking.booking_reference });
    } catch (err) { res.status(500).json({ success: false, error: err.message }); }
});

app.put('/api/bookings/:id', async (req, res) => {
    const booking = await Booking.findByIdAndUpdate(req.params.id, req.body, { new: true });
    res.json(booking);
});

app.delete('/api/bookings/:id', async (req, res) => {
    await Booking.findByIdAndDelete(req.params.id);
    await Passenger.deleteMany({ booking_id: req.params.id });
    res.json({ success: true });
});

app.listen(PORT, () => console.log(`🚀 Brain running on Port ${PORT}`));
