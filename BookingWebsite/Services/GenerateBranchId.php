<?php
function generateBranchId($con)
{
  define("BRANCHIDPREFIX", "br");
  define("BRANCHIDLENGTH", 2);

  $query = "SELECT branch_id  FROM branch ORDER BY branch_id DESC LIMIT 1";
  $res = mysqli_query($con, $query);

  if (mysqli_num_rows($res) > 0) {
    $branchId = mysqli_fetch_assoc($res)["branch_id"];
    $branchIdNumPart = explode('-', $branchId)[1];
    $branchIdNumPart++;
    $branchIdNumPart = str_pad($branchIdNumPart, BRANCHIDLENGTH, "0", STR_PAD_LEFT);
    return implode("-", [BRANCHIDPREFIX,  $branchIdNumPart]);
  }
  $branchIdNumPart = str_pad("1", BRANCHIDLENGTH, "0", STR_PAD_LEFT);
  return  implode("-", [BRANCHIDPREFIX, $branchIdNumPart]);
}