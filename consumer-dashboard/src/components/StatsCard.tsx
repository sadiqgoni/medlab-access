'use client';

import React from 'react';
import Link from 'next/link';
import { cn } from '@/lib/utils';

interface StatsCardProps {
  title: string;
  value: number | string;
  icon: React.ComponentType<any>;
  color: 'blue' | 'purple' | 'green' | 'red';
  description?: string;
  href?: string;
  badge?: string;
  trend?: {
    value: number;
    isPositive: boolean;
  };
}

const colorClasses = {
  blue: {
    iconBg: 'bg-blue-50',
    iconText: 'text-blue-600',
    accent: 'text-blue-600',
    link: 'text-blue-700 hover:text-blue-900',
  },
  purple: {
    iconBg: 'bg-purple-50',
    iconText: 'text-purple-600',
    accent: 'text-purple-600',
    link: 'text-purple-700 hover:text-purple-900',
  },
  green: {
    iconBg: 'bg-green-50',
    iconText: 'text-green-600',
    accent: 'text-green-600',
    link: 'text-green-700 hover:text-green-900',
  },
  red: {
    iconBg: 'bg-red-50',
    iconText: 'text-red-600',
    accent: 'text-red-600',
    link: 'text-red-700 hover:text-red-900',
  },
};

export default function StatsCard({
  title,
  value,
  icon: Icon,
  color,
  description,
  href,
  badge,
  trend,
}: StatsCardProps) {
  const colors = colorClasses[color];

  const content = (
    <div className="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
      <div className="p-6">
        <div className="flex items-center">
          <div className={cn('flex-shrink-0 rounded-xl p-3', colors.iconBg)}>
            <Icon className={cn('h-6 w-6', colors.iconText)} />
          </div>
          <div className="ml-4 w-0 flex-1">
            <dl>
              <dt className="text-sm font-medium text-gray-500 truncate">{title}</dt>
              <dd className="flex items-baseline">
                <div className="text-2xl font-semibold text-gray-900">{value}</div>
                {badge && (
                  <div className="ml-2 flex items-baseline text-sm font-semibold">
                    <span className={cn(
                      'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium',
                      color === 'purple' ? 'bg-purple-100 text-purple-800' :
                      color === 'blue' ? 'bg-blue-100 text-blue-800' :
                      color === 'green' ? 'bg-green-100 text-green-800' :
                      'bg-red-100 text-red-800'
                    )}>
                      {badge}
                    </span>
                  </div>
                )}
                {trend && (
                  <div className={cn(
                    'ml-2 flex items-baseline text-sm font-semibold',
                    trend.isPositive ? colors.accent : 'text-red-600'
                  )}>
                    <svg 
                      className="self-center flex-shrink-0 h-3 w-3" 
                      fill="currentColor" 
                      viewBox="0 0 20 20"
                    >
                      <path 
                        fillRule="evenodd" 
                        d={trend.isPositive 
                          ? "M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                          : "M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                        }
                        clipRule="evenodd" 
                      />
                    </svg>
                    <span className="sr-only">
                      {trend.isPositive ? 'Increased' : 'Decreased'}
                    </span>
                  </div>
                )}
              </dd>
            </dl>
          </div>
        </div>
      </div>
      {(description || href) && (
        <div className="bg-gray-50 px-6 py-3">
          <div className="text-sm">
            {href ? (
              <span className={cn('font-medium transition-colors', colors.link)}>
                {description || 'View details'} →
              </span>
            ) : (
              <span className="text-gray-600">{description}</span>
            )}
          </div>
        </div>
      )}
    </div>
  );

  if (href) {
    return <Link href={href}>{content}</Link>;
  }

  return content;
} 