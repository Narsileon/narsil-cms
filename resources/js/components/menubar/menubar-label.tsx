import { Menubar } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type MenubarLabelProps = React.ComponentProps<typeof Menubar.Label> & {
  inset?: boolean;
};

function MenubarLabel({ className, inset, ...props }: MenubarLabelProps) {
  return (
    <Menubar.Label
      data-slot="menubar-label"
      data-inset={inset}
      className={cn("px-2 py-1.5 font-medium", "data-[inset]:pl-8", className)}
      {...props}
    />
  );
}

export default MenubarLabel;
