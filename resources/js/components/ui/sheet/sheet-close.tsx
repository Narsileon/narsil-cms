import { Close } from "@radix-ui/react-dialog";

export type SheetCloseProps = React.ComponentProps<typeof Close> & {};

function SheetClose({ ...props }: SheetCloseProps) {
  return <Close data-slot="sheet-close" {...props} />;
}

export default SheetClose;
