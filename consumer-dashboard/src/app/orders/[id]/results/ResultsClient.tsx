'use client';

import React, { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { 
  ArrowLeftIcon,
  DocumentArrowDownIcon,
  PrinterIcon,
  ShareIcon,
  CalendarDaysIcon,
  UserIcon,
  IdentificationIcon,
  PhoneIcon,
  MapPinIcon,
  ClockIcon,
  BuildingOffice2Icon,
  ExclamationTriangleIcon,
  CheckCircleIcon,
  InformationCircleIcon,
  EyeIcon,
  DocumentTextIcon,
  ArrowsPointingOutIcon,
  ArrowsPointingInIcon
} from '@heroicons/react/24/outline';
import { useStore } from '@/store/useStore';
import { formatDate } from '@/lib/utils';
import { Order } from '@/types';

// Mock medical results data
const mockTestResults = {
  patientInfo: {
    name: 'John Doe',
    age: 34,
    gender: 'Male',
    patientId: 'P12345678',
    dateOfBirth: '1990-05-15',
    phone: '+234 803 123 4567',
    address: '123 Lagos Street, Victoria Island, Lagos'
  },
  facilityInfo: {
    name: 'Lagos Medical Center',
    address: '15 Ademola Street, Victoria Island, Lagos',
    phone: '+234 1 234 5678',
    email: 'lab@lagosmedical.ng',
    license: 'LMC-2024-001',
    accreditation: 'ISO 15189:2012'
  },
  testInfo: {
    testName: 'Full Blood Count (FBC)',
    sampleType: 'Whole Blood (EDTA)',
    collectionDate: '2024-01-15T08:30:00Z',
    receivedDate: '2024-01-15T10:15:00Z',
    reportedDate: '2024-01-15T16:45:00Z',
    reportId: 'LAB-FBC-240115-001',
    physician: 'Dr. Adebayo Williams',
    technologist: 'John Adeyemi, MLT'
  },
  results: [
    {
      parameter: 'Hemoglobin',
      value: '14.2',
      unit: 'g/dL',
      referenceRange: '12.0 - 16.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Red Blood Cell Count',
      value: '4.8',
      unit: '×10¹²/L',
      referenceRange: '4.2 - 5.4',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Hematocrit',
      value: '42.5',
      unit: '%',
      referenceRange: '36.0 - 48.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Mean Corpuscular Volume',
      value: '88.5',
      unit: 'fL',
      referenceRange: '80.0 - 100.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Mean Corpuscular Hemoglobin',
      value: '29.6',
      unit: 'pg',
      referenceRange: '27.0 - 33.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Mean Corpuscular Hemoglobin Concentration',
      value: '33.4',
      unit: 'g/dL',
      referenceRange: '32.0 - 36.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'White Blood Cell Count',
      value: '8.2',
      unit: '×10⁹/L',
      referenceRange: '4.0 - 11.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Neutrophils',
      value: '65.2',
      unit: '%',
      referenceRange: '50.0 - 70.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Lymphocytes',
      value: '28.5',
      unit: '%',
      referenceRange: '20.0 - 40.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Monocytes',
      value: '4.8',
      unit: '%',
      referenceRange: '2.0 - 8.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Eosinophils',
      value: '1.2',
      unit: '%',
      referenceRange: '1.0 - 4.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Basophils',
      value: '0.3',
      unit: '%',
      referenceRange: '0.0 - 1.0',
      status: 'normal',
      flag: ''
    },
    {
      parameter: 'Platelet Count',
      value: '320',
      unit: '×10⁹/L',
      referenceRange: '150 - 450',
      status: 'normal',
      flag: ''
    }
  ],
  interpretation: {
    summary: 'All parameters are within normal limits.',
    clinicalSignificance: 'The full blood count shows normal values for all measured parameters. No signs of anemia, infection, or blood disorders detected.',
    recommendations: [
      'Continue regular health monitoring',
      'Maintain balanced diet rich in iron and vitamins',
      'Follow up as clinically indicated'
    ],
    additionalNotes: 'This report should be interpreted in conjunction with clinical findings and other laboratory investigations.'
  }
};

interface ResultsClientProps {
  orderId: string;
}

export default function ResultsClient({ orderId }: ResultsClientProps) {
  const router = useRouter();
  const { orders, loading, fetchOrders } = useStore();
  const [order, setOrder] = useState<Order | null>(null);
  const [activeTab, setActiveTab] = useState<'pdf' | 'summary'>('pdf');
  const [isFullscreen, setIsFullscreen] = useState(false);

  useEffect(() => {
    if (orders.length === 0) {
      fetchOrders();
    }
  }, [orders.length, fetchOrders]);

  useEffect(() => {
    if (orders.length > 0 && orderId) {
      const foundOrder = orders.find(o => o.id.toString() === orderId);
      setOrder(foundOrder || null);
    }
  }, [orders, orderId]);

  const handlePrint = () => {
    window.print();
  };

  const handleDownloadPDF = async () => {
    try {
      // Generate PDF content
      const element = document.getElementById('pdf-content');
      if (!element) {
        alert('PDF content not found');
        return;
      }

      // Show loading message
      const button = document.querySelector('[title="Download PDF"]');
      const originalText = button?.innerHTML;
      if (button) {
        button.innerHTML = '<div class="animate-spin w-4 h-4 border-2 border-gray-600 border-t-transparent rounded-full"></div>';
        button.setAttribute('disabled', 'true');
      }

      // Try to use html2pdf library
      try {
        const html2pdf = await import('html2pdf.js');
        const opt = {
          margin: 0.5,
          filename: `Lab_Report_${mockTestResults.testInfo.reportId}.pdf`,
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2, useCORS: true },
          jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        
        await html2pdf.default().set(opt).from(element).save();
      } catch (pdfError) {
        console.log('PDF generation failed, using fallback:', pdfError);
        
        // Fallback: create a simple text version
        const textContent = generateTextReport();
        const blob = new Blob([textContent], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Lab_Report_${mockTestResults.testInfo.reportId}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        alert('PDF generation not available. Downloaded text version instead.');
      }
    } catch (error) {
      console.error('Download error:', error);
      alert('Download failed. Please try again.');
    } finally {
      // Restore button
      const button = document.querySelector('[title="Download PDF"]');
      if (button && button.innerHTML.includes('animate-spin')) {
        button.innerHTML = '<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
        button.removeAttribute('disabled');
      }
    }
  };

  const generateTextReport = () => {
    return `
LAGOS MEDICAL LABORATORY CENTER
15 ADEMOLA STREET, VICTORIA ISLAND, LAGOS
TEL: +234-1-234-5678 | EMAIL: LAB@LAGOSMEDICAL.NG
LICENSE: LMC-2024-001 | ACCREDITED: ISO 15189:2012

LABORATORY REPORT

PATIENT INFORMATION:
NAME: ${mockTestResults.patientInfo.name.toUpperCase()}
PATIENT ID: ${mockTestResults.patientInfo.patientId}
AGE/SEX: ${mockTestResults.patientInfo.age} YEARS / ${mockTestResults.patientInfo.gender.toUpperCase()}
DATE OF BIRTH: ${formatDate(mockTestResults.patientInfo.dateOfBirth).toUpperCase()}
PHONE: ${mockTestResults.patientInfo.phone}

SPECIMEN INFORMATION:
REPORT ID: ${mockTestResults.testInfo.reportId}
TEST NAME: ${mockTestResults.testInfo.testName.toUpperCase()}
SPECIMEN: ${mockTestResults.testInfo.sampleType.toUpperCase()}
COLLECTED: ${formatDate(mockTestResults.testInfo.collectionDate).toUpperCase()}
RECEIVED: ${formatDate(mockTestResults.testInfo.receivedDate).toUpperCase()}
REPORTED: ${formatDate(mockTestResults.testInfo.reportedDate).toUpperCase()}

TEST RESULTS:
${mockTestResults.results.map(result => 
  `${result.parameter}: ${result.value} ${result.unit} (Ref: ${result.referenceRange})`
).join('\n')}

CLINICAL INTERPRETATION:
SUMMARY: ${mockTestResults.interpretation.summary.toUpperCase()}
CLINICAL SIGNIFICANCE: ${mockTestResults.interpretation.clinicalSignificance}
RECOMMENDATIONS: ${mockTestResults.interpretation.recommendations.join('; ').toUpperCase()}

PERFORMED BY: ${mockTestResults.testInfo.technologist.toUpperCase()}
MEDICAL LABORATORY TECHNOLOGIST

REVIEWED BY: ${mockTestResults.testInfo.physician.toUpperCase()}
CONSULTANT PATHOLOGIST

Report generated: ${new Date().toLocaleDateString()}
`;
  };

  const handleShare = () => {
    alert('Share functionality would be implemented here');
  };

  const toggleFullscreen = () => {
    setIsFullscreen(!isFullscreen);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-96">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (!order) {
    return (
      <div className="text-center py-12">
        <h2 className="text-2xl font-bold text-gray-900 mb-4">Order not found</h2>
        <p className="text-gray-600 mb-6">The order you're looking for doesn't exist or may have been removed.</p>
        <Link
          href="/orders"
          className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          <ArrowLeftIcon className="w-4 h-4 mr-2" />
          Back to Orders
        </Link>
      </div>
    );
  }

  const renderPDFViewer = () => (
    <div className={`bg-white border border-gray-300 rounded-lg overflow-hidden ${isFullscreen ? 'fixed inset-4 z-50 shadow-2xl' : ''}`}>
      {/* PDF Toolbar */}
      <div className="bg-gray-100 border-b border-gray-300 px-2 md:px-4 py-3 flex items-center justify-between">
        <div className="flex items-center space-x-2 md:space-x-3 flex-1 min-w-0">
          <DocumentTextIcon className="w-4 md:w-5 h-4 md:h-5 text-gray-600 flex-shrink-0" />
          <span className="text-xs md:text-sm font-medium text-gray-900 truncate">Official Lab Report - {mockTestResults.testInfo.reportId}.pdf</span>
          <span className="text-xs bg-green-100 text-green-700 px-1 md:px-2 py-1 rounded-full flex-shrink-0 hidden sm:inline">Verified</span>
        </div>
        <div className="flex items-center space-x-1 md:space-x-2 flex-shrink-0">
          <button
            onClick={toggleFullscreen}
            className="p-2 hover:bg-gray-200 rounded-lg transition-colors"
            title={isFullscreen ? "Exit fullscreen" : "Fullscreen"}
          >
            {isFullscreen ? (
              <ArrowsPointingInIcon className="w-4 h-4 text-gray-600" />
            ) : (
              <ArrowsPointingOutIcon className="w-4 h-4 text-gray-600" />
            )}
          </button>
          <button
            onClick={handleDownloadPDF}
            className="p-2 hover:bg-gray-200 rounded-lg transition-colors"
            title="Download PDF"
          >
            <DocumentArrowDownIcon className="w-4 h-4 text-gray-600" />
          </button>
          <button
            onClick={handlePrint}
            className="p-2 hover:bg-gray-200 rounded-lg transition-colors"
            title="Print"
          >
            <PrinterIcon className="w-4 h-4 text-gray-600" />
          </button>
        </div>
      </div>

      {/* PDF Content - Medical Lab Report with Typewriter Font */}
      <div id="pdf-content" className="bg-white p-4 md:p-8 text-black font-mono text-xs md:text-sm leading-relaxed overflow-x-auto" style={{ fontFamily: 'Monaco, "Courier New", Courier, monospace' }}>
        {/* Lab Header */}
        <div className="text-center border-b-2 border-black pb-4 mb-6">
          <div className="text-base md:text-lg font-bold">LAGOS MEDICAL LABORATORY CENTER</div>
          <div className="text-xs md:text-sm mt-1">15 ADEMOLA STREET, VICTORIA ISLAND, LAGOS</div>
          <div className="text-xs md:text-sm break-all">TEL: +234-1-234-5678 | EMAIL: LAB@LAGOSMEDICAL.NG</div>
          <div className="text-xs md:text-sm">LICENSE: LMC-2024-001 | ACCREDITED: ISO 15189:2012</div>
          <div className="text-sm md:text-base font-bold mt-2 border border-black px-2 md:px-4 py-1 inline-block">
            LABORATORY REPORT
          </div>
        </div>

        {/* Report Info */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-6">
          <div>
            <div className="font-bold underline mb-2">PATIENT INFORMATION:</div>
            <div>NAME: {mockTestResults.patientInfo.name.toUpperCase()}</div>
            <div>PATIENT ID: {mockTestResults.patientInfo.patientId}</div>
            <div>AGE/SEX: {mockTestResults.patientInfo.age} YEARS / {mockTestResults.patientInfo.gender.toUpperCase()}</div>
            <div>DATE OF BIRTH: {formatDate(mockTestResults.patientInfo.dateOfBirth).toUpperCase()}</div>
            <div>PHONE: {mockTestResults.patientInfo.phone}</div>
          </div>
          <div>
            <div className="font-bold underline mb-2">SPECIMEN INFORMATION:</div>
            <div>REPORT ID: {mockTestResults.testInfo.reportId}</div>
            <div>TEST NAME: {mockTestResults.testInfo.testName.toUpperCase()}</div>
            <div>SPECIMEN: {mockTestResults.testInfo.sampleType.toUpperCase()}</div>
            <div>COLLECTED: {formatDate(mockTestResults.testInfo.collectionDate).toUpperCase()}</div>
            <div>RECEIVED: {formatDate(mockTestResults.testInfo.receivedDate).toUpperCase()}</div>
            <div>REPORTED: {formatDate(mockTestResults.testInfo.reportedDate).toUpperCase()}</div>
          </div>
        </div>

        {/* Results Table */}
        <div className="mb-6">
          <div className="font-bold underline mb-3">TEST RESULTS:</div>
          <div className="border border-black overflow-x-auto">
            <div className="bg-gray-100 border-b border-black px-1 md:px-2 py-1 font-bold grid grid-cols-5 gap-1 md:gap-2 min-w-full">
              <div className="text-xs md:text-sm">PARAMETER</div>
              <div className="text-center text-xs md:text-sm">RESULT</div>
              <div className="text-center text-xs md:text-sm">UNIT</div>
              <div className="text-center text-xs md:text-sm">REF RANGE</div>
              <div className="text-center text-xs md:text-sm">FLAG</div>
            </div>
            {mockTestResults.results.map((result, index) => (
              <div key={index} className={`px-1 md:px-2 py-1 border-b border-gray-300 grid grid-cols-5 gap-1 md:gap-2 min-w-full ${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}`}>
                <div className="text-xs md:text-sm truncate">{result.parameter}</div>
                <div className="text-center font-bold text-xs md:text-sm">{result.value}</div>
                <div className="text-center text-xs md:text-sm">{result.unit}</div>
                <div className="text-center text-xs md:text-sm">{result.referenceRange}</div>
                <div className="text-center text-xs md:text-sm">
                  {result.status === 'normal' ? '' : 
                   result.status === 'high' ? 'H' : 
                   result.status === 'low' ? 'L' : ''}
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Clinical Notes */}
        <div className="mb-6">
          <div className="font-bold underline mb-2">CLINICAL INTERPRETATION:</div>
          <div className="border border-black p-2">
            <div className="mb-2">
              <span className="font-bold">SUMMARY: </span>
              {mockTestResults.interpretation.summary.toUpperCase()}
            </div>
            <div className="mb-2">
              <span className="font-bold">CLINICAL SIGNIFICANCE: </span>
              {mockTestResults.interpretation.clinicalSignificance}
            </div>
            <div>
              <span className="font-bold">RECOMMENDATIONS: </span>
              {mockTestResults.interpretation.recommendations.join('; ').toUpperCase()}
            </div>
          </div>
        </div>

        {/* Footer */}
        <div className="border-t-2 border-black pt-4">
          <div className="grid grid-cols-2 gap-8">
            <div>
              <div className="font-bold underline">PERFORMED BY:</div>
              <div className="mt-2">
                <div>{mockTestResults.testInfo.technologist.toUpperCase()}</div>
                <div>MEDICAL LABORATORY TECHNOLOGIST</div>
                <div className="mt-1">________________________</div>
                <div className="text-xs"> SIGNATURE</div>
              </div>
            </div>
            <div>
              <div className="font-bold underline">REVIEWED BY:</div>
              <div className="mt-2">
                <div>{mockTestResults.testInfo.physician.toUpperCase()}</div>
                <div>CONSULTANT PATHOLOGIST</div>
                <div className="mt-1">________________________</div>
                <div className="text-xs"> SIGNATURE</div>
              </div>
            </div>
          </div>
          <div className="text-center mt-4 text-xs">
            <div>*** END OF REPORT ***</div>
            {/* <div className="mt-2">THIS REPORT IS COMPUTER GENERATED AND DIGITALLY SIGNED</div> */}
            <div>REPORT GENERATED ON: {formatDate(new Date().toISOString()).toUpperCase()}</div>
          </div>
        </div>
      </div>
    </div>
  );

  const renderStructuredSummary = () => (
    <div className="space-y-6">
      {/* Patient Information */}
      <div className="bg-white rounded-lg border border-gray-200 p-6">
        <h3 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
          <UserIcon className="w-5 h-5 mr-2 text-blue-600" />
          Patient Information
        </h3>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="space-y-2">
            <div className="flex">
              <span className="font-medium text-gray-600 w-24">Name:</span>
              <span className="font-semibold">{mockTestResults.patientInfo.name}</span>
            </div>
            <div className="flex">
              <span className="font-medium text-gray-600 w-24">Patient ID:</span>
              <span>{mockTestResults.patientInfo.patientId}</span>
            </div>
            <div className="flex">
              <span className="font-medium text-gray-600 w-24">Age/Gender:</span>
              <span>{mockTestResults.patientInfo.age} years, {mockTestResults.patientInfo.gender}</span>
            </div>
          </div>
          <div className="space-y-2">
            <div className="flex">
              <span className="font-medium text-gray-600 w-24">DOB:</span>
              <span>{formatDate(mockTestResults.patientInfo.dateOfBirth)}</span>
            </div>
            <div className="flex">
              <span className="font-medium text-gray-600 w-24">Phone:</span>
              <span>{mockTestResults.patientInfo.phone}</span>
            </div>
          </div>
        </div>
      </div>

      {/* Test Results Summary */}
      <div className="bg-white rounded-lg border border-gray-200 p-6">
        <h3 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
          <CheckCircleIcon className="w-5 h-5 mr-2 text-green-600" />
          Results Summary
        </h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
          <div className="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
            <div className="text-2xl font-bold text-green-600">
              {mockTestResults.results.filter(r => r.status === 'normal').length}
            </div>
            <div className="text-sm text-green-700">Normal Values</div>
          </div>
          <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
            <div className="text-2xl font-bold text-yellow-600">
              {mockTestResults.results.filter(r => r.status === 'low').length}
            </div>
            <div className="text-sm text-yellow-700">Low Values</div>
          </div>
          <div className="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
            <div className="text-2xl font-bold text-red-600">
              {mockTestResults.results.filter(r => r.status === 'high').length}
            </div>
            <div className="text-sm text-red-700">High Values</div>
          </div>
        </div>
        
        {/* Quick Results Table */}
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-3 py-2 text-left font-medium text-gray-700">Parameter</th>
                <th className="px-3 py-2 text-center font-medium text-gray-700">Result</th>
                <th className="px-3 py-2 text-center font-medium text-gray-700">Status</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-200">
              {mockTestResults.results.slice(0, 5).map((result, index) => (
                <tr key={index}>
                  <td className="px-3 py-2 font-medium">{result.parameter}</td>
                  <td className="px-3 py-2 text-center">{result.value} {result.unit}</td>
                  <td className="px-3 py-2 text-center">
                    <span className={`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${
                      result.status === 'normal' ? 'bg-green-100 text-green-800' :
                      result.status === 'high' ? 'bg-red-100 text-red-800' :
                      result.status === 'low' ? 'bg-yellow-100 text-yellow-800' :
                      'bg-gray-100 text-gray-800'
                    }`}>
                      {result.status.charAt(0).toUpperCase() + result.status.slice(1)}
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
          {mockTestResults.results.length > 5 && (
            <div className="text-center py-2 text-sm text-gray-500">
              +{mockTestResults.results.length - 5} more parameters (see full PDF report)
            </div>
          )}
        </div>
      </div>

      {/* Clinical Interpretation */}
      <div className="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 className="text-lg font-semibold text-blue-900 mb-4 flex items-center">
          <InformationCircleIcon className="w-5 h-5 mr-2" />
          Clinical Interpretation
        </h3>
        <div className="space-y-3 text-blue-800">
          <div>
            <span className="font-semibold">Summary: </span>
            {mockTestResults.interpretation.summary}
          </div>
          <div>
            <span className="font-semibold">Clinical Significance: </span>
            {mockTestResults.interpretation.clinicalSignificance}
          </div>
          <div>
            <span className="font-semibold">Recommendations: </span>
            <ul className="list-disc list-inside mt-1">
              {mockTestResults.interpretation.recommendations.map((rec, index) => (
                <li key={index}>{rec}</li>
              ))}
            </ul>
          </div>
        </div>
      </div>
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white border-b border-gray-200 px-6 py-4 print:hidden">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => router.back()}
              className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
            >
              <ArrowLeftIcon className="w-5 h-5" />
            </button>
            <div>
              <h1 className="text-xl font-semibold text-gray-900">Medical Test Results</h1>
              <p className="text-gray-600">Order #{order.id} • {mockTestResults.testInfo.testName}</p>
            </div>
          </div>
          
          <div className="flex items-center space-x-3">
            <button
              onClick={handleShare}
              className="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"
            >
              <ShareIcon className="w-4 h-4 mr-2" />
              Share
            </button>
            <button
              onClick={handleDownloadPDF}
              className="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm"
            >
              <DocumentArrowDownIcon className="w-4 h-4 mr-2" />
              Download PDF
            </button>
            <button
              onClick={handlePrint}
              className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm"
            >
              <PrinterIcon className="w-4 h-4 mr-2" />
              Print
            </button>
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="max-w-6xl mx-auto px-6 py-8">
        {/* Tab Navigation */}
        <div className="mb-6">
          <div className="border-b border-gray-200">
            <nav className="-mb-px flex space-x-8">
              <button
                onClick={() => setActiveTab('pdf')}
                className={`py-2 px-1 border-b-2 font-medium text-sm ${
                  activeTab === 'pdf'
                    ? 'border-blue-500 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                }`}
              >
                <DocumentTextIcon className="w-5 h-5 inline mr-2" />
                Official Lab Report (PDF)
              </button>
              <button
                onClick={() => setActiveTab('summary')}
                className={`py-2 px-1 border-b-2 font-medium text-sm ${
                  activeTab === 'summary'
                    ? 'border-blue-500 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                }`}
              >
                <EyeIcon className="w-5 h-5 inline mr-2" />
                Test Summary & Details
              </button>
            </nav>
          </div>
        </div>

        {/* Tab Content */}
        <div>
          {activeTab === 'pdf' && renderPDFViewer()}
          {activeTab === 'summary' && renderStructuredSummary()}
        </div>
      </div>
    </div>
  );
} 