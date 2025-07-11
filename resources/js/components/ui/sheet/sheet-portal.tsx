import { Dialog as SheetPrimitive } from "radix-ui";

type SheetPortalProps = React.ComponentProps<typeof SheetPrimitive.Portal> & {};

function SheetPortal({ ...props }: SheetPortalProps) {
  return <SheetPrimitive.Portal data-slot="sheet-portal" {...props} />;
}

export default SheetPortal;
