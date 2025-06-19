import { Portal } from "@radix-ui/react-dialog";

export type SheetPortalProps = React.ComponentProps<typeof Portal> & {};

function SheetPortal({ ...props }: SheetPortalProps) {
  return <Portal data-slot="sheet-portal" {...props} />;
}

export default SheetPortal;
