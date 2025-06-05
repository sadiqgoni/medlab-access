'use client';

import React, { useState } from 'react';
import { 
  BellIcon,
  ShieldCheckIcon,
  MoonIcon,
  GlobeAltIcon,
  DevicePhoneMobileIcon,
} from '@heroicons/react/24/outline';

export default function SettingsPage() {
  const [settings, setSettings] = useState({
    emailNotifications: true,
    smsNotifications: true,
    pushNotifications: false,
    darkMode: false,
    language: 'en',
    twoFactorAuth: false,
  });

  const handleToggle = (key: keyof typeof settings) => {
    setSettings(prev => ({
      ...prev,
      [key]: !prev[key]
    }));
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-2xl font-bold text-gray-900">Settings</h1>
        <p className="text-gray-600">Manage your account preferences and settings</p>
      </div>

      {/* Notifications */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div className="flex items-center mb-4">
          <BellIcon className="h-6 w-6 text-blue-600 mr-3" />
          <h2 className="text-lg font-semibold text-gray-900">Notifications</h2>
        </div>
        
        <div className="space-y-4">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">Email Notifications</h3>
              <p className="text-sm text-gray-600">Receive updates about your orders via email</p>
            </div>
            <button
              onClick={() => handleToggle('emailNotifications')}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                settings.emailNotifications ? 'bg-blue-600' : 'bg-gray-200'
              }`}
            >
              <span className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                settings.emailNotifications ? 'translate-x-6' : 'translate-x-1'
              }`} />
            </button>
          </div>

          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">SMS Notifications</h3>
              <p className="text-sm text-gray-600">Get text messages for urgent updates</p>
            </div>
            <button
              onClick={() => handleToggle('smsNotifications')}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                settings.smsNotifications ? 'bg-blue-600' : 'bg-gray-200'
              }`}
            >
              <span className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                settings.smsNotifications ? 'translate-x-6' : 'translate-x-1'
              }`} />
            </button>
          </div>

          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">Push Notifications</h3>
              <p className="text-sm text-gray-600">Browser notifications for real-time updates</p>
            </div>
            <button
              onClick={() => handleToggle('pushNotifications')}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                settings.pushNotifications ? 'bg-blue-600' : 'bg-gray-200'
              }`}
            >
              <span className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                settings.pushNotifications ? 'translate-x-6' : 'translate-x-1'
              }`} />
            </button>
          </div>
        </div>
      </div>

      {/* Security */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div className="flex items-center mb-4">
          <ShieldCheckIcon className="h-6 w-6 text-green-600 mr-3" />
          <h2 className="text-lg font-semibold text-gray-900">Security</h2>
        </div>
        
        <div className="space-y-4">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
              <p className="text-sm text-gray-600">Add an extra layer of security to your account</p>
            </div>
            <button
              onClick={() => handleToggle('twoFactorAuth')}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                settings.twoFactorAuth ? 'bg-green-600' : 'bg-gray-200'
              }`}
            >
              <span className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                settings.twoFactorAuth ? 'translate-x-6' : 'translate-x-1'
              }`} />
            </button>
          </div>
        </div>
      </div>

      {/* Preferences */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div className="flex items-center mb-4">
          <GlobeAltIcon className="h-6 w-6 text-purple-600 mr-3" />
          <h2 className="text-lg font-semibold text-gray-900">Preferences</h2>
        </div>
        
        <div className="space-y-4">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">Dark Mode</h3>
              <p className="text-sm text-gray-600">Use dark theme for better night viewing</p>
            </div>
            <button
              onClick={() => handleToggle('darkMode')}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                settings.darkMode ? 'bg-gray-800' : 'bg-gray-200'
              }`}
            >
              <span className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                settings.darkMode ? 'translate-x-6' : 'translate-x-1'
              }`} />
            </button>
          </div>

          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-sm font-medium text-gray-900">Language</h3>
              <p className="text-sm text-gray-600">Choose your preferred language</p>
            </div>
            <select
              value={settings.language}
              onChange={(e) => setSettings(prev => ({ ...prev, language: e.target.value }))}
              className="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="en">English</option>
              <option value="ha">Hausa</option>
            </select>
          </div>
        </div>
      </div>

      {/* Mobile App */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div className="flex items-center mb-4">
          <DevicePhoneMobileIcon className="h-6 w-6 text-blue-600 mr-3" />
          <h2 className="text-lg font-semibold text-gray-900">Mobile App</h2>
        </div>
        
        <div className="text-center py-6">
          <DevicePhoneMobileIcon className="h-16 w-16 text-gray-400 mx-auto mb-4" />
          <h3 className="text-lg font-medium text-gray-900 mb-2">Download DHR SPACE App</h3>
          <p className="text-gray-600 mb-6">
            Get the mobile app for faster access to your health services
          </p>
          <div className="flex justify-center space-x-4">
            <button className="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
              App Store
            </button>
            <button className="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
              Google Play
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}