import * as React from "react";
import { Dialog as SheetPrimitive } from "radix-ui";

type SheetCloseProps = React.ComponentProps<typeof SheetPrimitive.Close> & {};

function SheetClose({ ...props }: SheetCloseProps) {
  return <SheetPrimitive.Close data-slot="sheet-close" {...props} />;
}

export default SheetClose;
