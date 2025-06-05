'use client';

import React, { useEffect, useState } from 'react';
import { 
  UserIcon,
  EnvelopeIcon,
  PhoneIcon,
  MapPinIcon,
  PencilIcon,
  CheckIcon,
  XMarkIcon,
} from '@heroicons/react/24/outline';
import { useStore } from '@/store/useStore';
import { userApi } from '@/lib/api';

export default function ProfilePage() {
  const { user, setUser, loading } = useStore();
  const [isEditing, setIsEditing] = useState(false);
  const [editForm, setEditForm] = useState({
    name: '',
    email: '',
    phone: '',
    address: '',
    bloodType: '',
  });
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    if (user) {
      setEditForm({
        name: user.name || '',
        email: user.email || '',
        phone: user.phone || '',
        address: user.address || '',
        bloodType: user.bloodType || '',
      });
    }
  }, [user]);

  const handleSave = async () => {
    if (!user) return;
    
    setSaving(true);
    try {
      const updatedUser = await userApi.updateProfile(editForm);
      setUser(updatedUser);
      setIsEditing(false);
    } catch (error) {
      console.error('Failed to update profile:', error);
    } finally {
      setSaving(false);
    }
  };

  const handleCancel = () => {
    if (user) {
      setEditForm({
        name: user.name || '',
        email: user.email || '',
        phone: user.phone || '',
        address: user.address || '',
        bloodType: user.bloodType || '',
      });
    }
    setIsEditing(false);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">Profile</h1>
          <p className="text-gray-600">Manage your personal information</p>
        </div>
        
        {!isEditing ? (
          <button
            onClick={() => setIsEditing(true)}
            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            <PencilIcon className="w-4 h-4 mr-2" />
            Edit Profile
          </button>
        ) : (
          <div className="flex items-center space-x-2">
            <button
              onClick={handleCancel}
              className="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
              <XMarkIcon className="w-4 h-4 mr-2" />
              Cancel
            </button>
            <button
              onClick={handleSave}
              disabled={saving}
              className="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50"
            >
              <CheckIcon className="w-4 h-4 mr-2" />
              {saving ? 'Saving...' : 'Save'}
            </button>
          </div>
        )}
      </div>

      {/* Profile Card */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {/* Profile Header */}
        <div className="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
          <div className="flex items-center">
            <div className="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center mr-6">
              <span className="text-white text-2xl font-bold">
                {user?.name?.charAt(0) || 'U'}
              </span>
            </div>
            <div>
              <h2 className="text-2xl font-bold text-white">{user?.name}</h2>
              <p className="text-blue-100">{user?.email}</p>
              <p className="text-blue-100 text-sm">
                Member since {user?.created_at ? new Date(user.created_at).getFullYear() : 'N/A'}
              </p>
            </div>
          </div>
        </div>

        {/* Profile Information */}
        <div className="p-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Personal Information */}
            <div className="space-y-4">
              <h3 className="text-lg font-semibold text-gray-900 border-b pb-2">
                Personal Information
              </h3>
              
              {/* Name */}
              <div className="flex items-center space-x-3">
                <UserIcon className="h-5 w-5 text-gray-400 flex-shrink-0" />
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                  </label>
                  {isEditing ? (
                    <input
                      type="text"
                      value={editForm.name}
                      onChange={(e) => setEditForm({ ...editForm, name: e.target.value })}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                  ) : (
                    <p className="text-gray-900">{user?.name || 'Not provided'}</p>
                  )}
                </div>
              </div>

              {/* Email */}
              <div className="flex items-center space-x-3">
                <EnvelopeIcon className="h-5 w-5 text-gray-400 flex-shrink-0" />
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                  </label>
                  {isEditing ? (
                    <input
                      type="email"
                      value={editForm.email}
                      onChange={(e) => setEditForm({ ...editForm, email: e.target.value })}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                  ) : (
                    <p className="text-gray-900">{user?.email || 'Not provided'}</p>
                  )}
                </div>
              </div>

              {/* Phone */}
              <div className="flex items-center space-x-3">
                <PhoneIcon className="h-5 w-5 text-gray-400 flex-shrink-0" />
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Phone Number
                  </label>
                  {isEditing ? (
                    <input
                      type="tel"
                      value={editForm.phone}
                      onChange={(e) => setEditForm({ ...editForm, phone: e.target.value })}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="+234 XXX XXX XXXX"
                    />
                  ) : (
                    <p className="text-gray-900">{user?.phone || 'Not provided'}</p>
                  )}
                </div>
              </div>
            </div>

            {/* Additional Information */}
            <div className="space-y-4">
              <h3 className="text-lg font-semibold text-gray-900 border-b pb-2">
                Additional Information
              </h3>

              {/* Address */}
              <div className="flex items-start space-x-3">
                <MapPinIcon className="h-5 w-5 text-gray-400 flex-shrink-0 mt-1" />
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Address
                  </label>
                  {isEditing ? (
                    <textarea
                      value={editForm.address}
                      onChange={(e) => setEditForm({ ...editForm, address: e.target.value })}
                      rows={3}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Enter your full address"
                    />
                  ) : (
                    <p className="text-gray-900">{user?.address || 'Not provided'}</p>
                  )}
                </div>
              </div>

              {/* Blood Type */}
              <div className="flex items-center space-x-3">
                <div className="h-5 w-5 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                  <span className="text-red-600 text-xs font-bold">B</span>
                </div>
                <div className="flex-1">
                  <label className="block text-sm font-medium text-gray-700 mb-1">
                    Blood Type
                  </label>
                  {isEditing ? (
                    <select
                      value={editForm.bloodType}
                      onChange={(e) => setEditForm({ ...editForm, bloodType: e.target.value })}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                      <option value="">Select Blood Type</option>
                      <option value="A+">A+</option>
                      <option value="A-">A-</option>
                      <option value="B+">B+</option>
                      <option value="B-">B-</option>
                      <option value="AB+">AB+</option>
                      <option value="AB-">AB-</option>
                      <option value="O+">O+</option>
                      <option value="O-">O-</option>
                    </select>
                  ) : (
                    <p className="text-gray-900">{user?.bloodType || 'Not provided'}</p>
                  )}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Account Statistics */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 className="text-lg font-semibold text-gray-900 mb-4">Account Statistics</h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="text-center p-4 bg-blue-50 rounded-lg">
            <div className="text-2xl font-bold text-blue-600">--</div>
            <div className="text-sm text-gray-600">Total Orders</div>
          </div>
          <div className="text-center p-4 bg-green-50 rounded-lg">
            <div className="text-2xl font-bold text-green-600">--</div>
            <div className="text-sm text-gray-600">Completed Tests</div>
          </div>
          <div className="text-center p-4 bg-purple-50 rounded-lg">
            <div className="text-2xl font-bold text-purple-600">--</div>
            <div className="text-sm text-gray-600">Years as Member</div>
          </div>
        </div>
      </div>
    </div>
  );
}