<?php
enum bookingStatus: string
{
  case BOOKED = "BOOKED";
  case COMPLETED = "COMPLETED";
  case CHECKED_IN = "CHECKED_IN";
  case CANCELLED = "CANCELLED";
}
