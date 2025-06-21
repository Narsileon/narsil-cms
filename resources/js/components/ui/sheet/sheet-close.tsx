import { Dialog as SheetPrimitive } from "radix-ui";

export type SheetCloseProps = React.ComponentProps<
  typeof SheetPrimitive.Close
> & {};

function SheetClose({ ...props }: SheetCloseProps) {
  return <SheetPrimitive.Close data-slot="sheet-close" {...props} />;
}

export default SheetClose;
