USE [ODS]
GO

/****** Object:  StoredProcedure [dbo].[usp_WebAppFeeUpdatePayment]    Script Date: 04/08/2015 09:06:54 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[usp_WebAppFeeUpdatePayment]') AND type in (N'P', N'PC'))
DROP PROCEDURE [dbo].[usp_WebAppFeeUpdatePayment]
GO

USE [ODS]
GO

/****** Object:  StoredProcedure [dbo].[usp_WebAppFeeUpdatePayment]    Script Date: 04/08/2015 09:06:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

/****************************************************************************************************************************************************
CREATED:
04/01/2015   Smruthi Madhugiri    This stored procedure is created to update the payment status once the payment has been authorized or settled.

****************************************************************************************************************************************************/
CREATE PROCEDURE [dbo].[usp_WebAppFeeUpdatePayment]
	@ReferenceNumber int,
	@PaymentStatus varchar(10),
	@BillingFirstName varchar(32),
	@BillingLastName varchar(32),
	@BillingEmail varchar(200),
	@BillingPhoneNumber varchar(10)
AS
BEGIN


	SET NOCOUNT ON;


	IF (@PaymentStatus = 'AUTHORIZED')

		BEGIN
			UPDATE [BCAdmission]
				SET PaymentAuthorization = getdate()
					, BillingFirstName = @BillingFirstName
					, BillingLastName = @BillingLastName
					, BillingEmail = @BillingEmail
					, BillingPhoneNumber = @BillingPhoneNumber
				WHERE ReferenceNumber = @ReferenceNumber;
		END

	ELSE IF(@PaymentStatus = 'SETTLED')

		BEGIN
			UPDATE [BCAdmission]
				SET PaymentSettled = getdate()
				WHERE ReferenceNumber = @ReferenceNumber
		END


END

GO
