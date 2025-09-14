import { Menubar } from "radix-ui";

type MenubarSubProps = React.ComponentProps<typeof Menubar.Sub> & {};

function MenubarSub({ ...props }: MenubarSubProps) {
  return <Menubar.Sub data-slot="menubar-sub" {...props} />;
}

export default MenubarSub;
