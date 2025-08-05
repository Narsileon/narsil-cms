import * as React from "react";
import { Dialog as SheetPrimitive } from "radix-ui";

type SheetTriggerProps = React.ComponentProps<
  typeof SheetPrimitive.Trigger
> & {};

function SheetTrigger({ ...props }: SheetTriggerProps) {
  return <SheetPrimitive.Trigger data-slot="sheet-trigger" {...props} />;
}

export default SheetTrigger;
