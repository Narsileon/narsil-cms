import { Dialog as SheetPrimitive } from "radix-ui";

export type SheetProps = React.ComponentProps<typeof SheetPrimitive.Root> & {};

function Sheet({ ...props }: SheetProps) {
  return <SheetPrimitive.Root data-slot="sheet" {...props} />;
}

export default Sheet;
