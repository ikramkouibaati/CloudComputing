import React from "react";
import { ProgressBar } from "react-bootstrap";

function OrderSteps({ currentStep }) {
  return (
    <div className="order-steps">
      <ProgressBar now={currentStep * 25} />

      <div className="step-container">
        <div className={`step ${currentStep === 1 ? "active" : ""}`}>
          
        </div>
        <div className={`step ${currentStep === 2 ? "active" : ""}`}>
          
        </div>
        <div className={`step ${currentStep === 3 ? "active" : ""}`}>
        
        </div>
        <div className={`step ${currentStep === 4 ? "active" : ""}`}>
        <br/>
        </div>
       
      </div>
    </div>
  );
}

export default OrderSteps;
