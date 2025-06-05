'use client';

import React, { useState } from 'react';
import { useSearchParams } from 'next/navigation';

export default function NewOrder() {
  const searchParams = useSearchParams();
  const type = searchParams.get('type') || 'test';
  
  const [orderType, setOrderType] = useState(type);
  const [formData, setFormData] = useState({
    testType: '',
    facility: '',
    preferredDate: '',
    preferredTime: '',
    urgency: 'normal',
    notes: '',
    // Blood service specific
    bloodType: '',
    units: 1,
    serviceType: 'donation'
  });

  const labTests = [
    'Full Blood Count (FBC)',
    'Blood Glucose',
    'Lipid Profile',
    'Liver Function Test',
    'Kidney Function Test',
    'Thyroid Function Test',
    'HIV Test',
    'Hepatitis B & C',
    'Malaria Test',
    'Pregnancy Test'
  ];

  const facilities = [
    { id: 1, name: 'Lagos Medical Center', address: 'Victoria Island, Lagos', rating: 4.8 },
    { id: 2, name: 'Abuja Diagnostic Center', address: 'Central Area, Abuja', rating: 4.7 },
    { id: 3, name: 'Kano Blood Bank', address: 'Sabon Gari, Kano', rating: 4.6 },
    { id: 4, name: 'Port Harcourt Lab', address: 'GRA, Port Harcourt', rating: 4.9 }
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log('Order submitted:', { orderType, ...formData });
    // Handle form submission
  };

  return (
    <div className="max-w-4xl mx-auto animate-fade-in">
      {/* Header */}
      <div className="mb-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Create New Order</h1>
        <p className="text-gray-600">Book your medical tests and blood services with ease</p>
      </div>

      {/* Service Type Selector */}
      <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
        <h2 className="text-xl font-semibold text-gray-900 mb-4">Select Service Type</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <button
            onClick={() => setOrderType('test')}
            className={`p-6 rounded-lg border-2 transition-all duration-200 ${
              orderType === 'test'
                ? 'border-blue-500 bg-blue-50 text-blue-700'
                : 'border-gray-200 hover:border-blue-300 hover:bg-blue-50'
            }`}
          >
            <div className="flex items-center">
              <div className="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                <i className="fas fa-vial text-blue-600 text-xl"></i>
              </div>
              <div className="text-left">
                <h3 className="font-semibold text-lg">Lab Tests</h3>
                <p className="text-sm text-gray-600">Blood tests, diagnostics, and health screenings</p>
              </div>
            </div>
          </button>

          <button
            onClick={() => setOrderType('blood')}
            className={`p-6 rounded-lg border-2 transition-all duration-200 ${
              orderType === 'blood'
                ? 'border-red-500 bg-red-50 text-red-700'
                : 'border-gray-200 hover:border-red-300 hover:bg-red-50'
            }`}
          >
            <div className="flex items-center">
              <div className="h-12 w-12 rounded-lg bg-red-100 flex items-center justify-center mr-4">
                <i className="fas fa-tint text-red-600 text-xl"></i>
              </div>
              <div className="text-left">
                <h3 className="font-semibold text-lg">Blood Services</h3>
                <p className="text-sm text-gray-600">Blood donation, transfusion, and banking</p>
              </div>
            </div>
          </button>
        </div>
      </div>

      {/* Order Form */}
      <form onSubmit={handleSubmit} className="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 className="text-xl font-semibold text-gray-900 mb-6">
          {orderType === 'test' ? 'Lab Test Details' : 'Blood Service Details'}
        </h2>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {/* Test Type / Service Type */}
          {orderType === 'test' ? (
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Select Test Type
              </label>
              <select
                value={formData.testType}
                onChange={(e) => setFormData({ ...formData, testType: e.target.value })}
                className="form-input"
                required
              >
                <option value="">Choose a test...</option>
                {labTests.map((test) => (
                  <option key={test} value={test}>{test}</option>
                ))}
              </select>
            </div>
          ) : (
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Service Type
              </label>
              <select
                value={formData.serviceType}
                onChange={(e) => setFormData({ ...formData, serviceType: e.target.value })}
                className="form-input"
                required
              >
                <option value="donation">Blood Donation</option>
                <option value="transfusion">Blood Transfusion</option>
                <option value="testing">Blood Testing</option>
                <option value="storage">Blood Storage</option>
              </select>
            </div>
          )}

          {/* Blood Type (for blood services) */}
          {orderType === 'blood' && (
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Blood Type
              </label>
              <select
                value={formData.bloodType}
                onChange={(e) => setFormData({ ...formData, bloodType: e.target.value })}
                className="form-input"
                required
              >
                <option value="">Select blood type...</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
              </select>
            </div>
          )}

          {/* Facility Selection */}
          <div className={orderType === 'blood' ? '' : 'md:col-span-2'}>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Select Facility
            </label>
            <select
              value={formData.facility}
              onChange={(e) => setFormData({ ...formData, facility: e.target.value })}
              className="form-input"
              required
            >
              <option value="">Choose a facility...</option>
              {facilities.map((facility) => (
                <option key={facility.id} value={facility.name}>
                  {facility.name} - {facility.address} ⭐ {facility.rating}
                </option>
              ))}
            </select>
          </div>

          {/* Units (for blood services) */}
          {orderType === 'blood' && (
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Units Required
              </label>
              <input
                type="number"
                min="1"
                max="10"
                value={formData.units}
                onChange={(e) => setFormData({ ...formData, units: parseInt(e.target.value) })}
                className="form-input"
                required
              />
            </div>
          )}

          {/* Preferred Date */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Preferred Date
            </label>
            <input
              type="date"
              value={formData.preferredDate}
              onChange={(e) => setFormData({ ...formData, preferredDate: e.target.value })}
              className="form-input"
              required
              min={new Date().toISOString().split('T')[0]}
            />
          </div>

          {/* Preferred Time */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Preferred Time
            </label>
            <select
              value={formData.preferredTime}
              onChange={(e) => setFormData({ ...formData, preferredTime: e.target.value })}
              className="form-input"
              required
            >
              <option value="">Select time...</option>
              <option value="08:00">8:00 AM</option>
              <option value="09:00">9:00 AM</option>
              <option value="10:00">10:00 AM</option>
              <option value="11:00">11:00 AM</option>
              <option value="12:00">12:00 PM</option>
              <option value="13:00">1:00 PM</option>
              <option value="14:00">2:00 PM</option>
              <option value="15:00">3:00 PM</option>
              <option value="16:00">4:00 PM</option>
              <option value="17:00">5:00 PM</option>
            </select>
          </div>

          {/* Urgency */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Urgency Level
            </label>
            <select
              value={formData.urgency}
              onChange={(e) => setFormData({ ...formData, urgency: e.target.value })}
              className="form-input"
            >
              <option value="normal">Normal</option>
              <option value="urgent">Urgent</option>
              <option value="emergency">Emergency</option>
            </select>
          </div>

          {/* Notes */}
          <div className="md:col-span-2">
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Additional Notes
            </label>
            <textarea
              value={formData.notes}
              onChange={(e) => setFormData({ ...formData, notes: e.target.value })}
              rows={3}
              className="form-input resize-none"
              placeholder="Any special instructions or requirements..."
            />
          </div>
        </div>

        {/* Emergency Notice */}
        {formData.urgency === 'emergency' && (
          <div className="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div className="flex items-center">
              <div className="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center mr-3 emergency-pulse">
                <i className="fas fa-exclamation text-white text-sm"></i>
              </div>
              <div>
                <h4 className="font-semibold text-red-800">Emergency Request</h4>
                <p className="text-sm text-red-700">
                  For immediate medical emergencies, please call 112 or visit the nearest emergency room.
                </p>
              </div>
            </div>
          </div>
        )}

        {/* Form Actions */}
        <div className="mt-8 flex flex-col sm:flex-row gap-4">
          <button
            type="submit"
            className="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors btn-animate"
          >
            <i className="fas fa-calendar-check mr-2"></i>
            Book Appointment
          </button>
          <button
            type="button"
            className="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors"
            onClick={() => window.history.back()}
          >
            <i className="fas fa-arrow-left mr-2"></i>
            Cancel
          </button>
        </div>

        {/* Cost Estimate */}
        <div className="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
          <div className="flex items-center justify-between">
            <div>
              <h4 className="font-semibold text-blue-800">Estimated Cost</h4>
              <p className="text-sm text-blue-700">
                {orderType === 'test' 
                  ? 'Lab test fees may vary by facility and test type'
                  : formData.serviceType === 'donation' 
                    ? 'Blood donation is typically free'
                    : 'Blood service fees may vary by facility and requirements'
                }
              </p>
            </div>
            <div className="text-right">
              <span className="text-2xl font-bold text-blue-600">
                {orderType === 'test' 
                  ? '₦8,000 - ₦25,000'
                  : formData.serviceType === 'donation'
                    ? 'Free'
                    : '₦15,000 - ₦50,000'
                }
              </span>
            </div>
          </div>
        </div>
      </form>
    </div>
  );
} 