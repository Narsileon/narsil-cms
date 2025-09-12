import { Dialog as SheetPrimitive } from "radix-ui";

type SheetRootProps = React.ComponentProps<typeof SheetPrimitive.Root> & {};

function SheetRoot({ ...props }: SheetRootProps) {
  return <SheetPrimitive.Root data-slot="sheet-root" {...props} />;
}

export default SheetRoot;
