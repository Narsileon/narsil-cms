import { type ComponentProps } from "react";

import { ShortcutRoot } from "@narsil-cms/components/shortcut";

type ShortcutProps = ComponentProps<typeof ShortcutRoot> & {};

function Shortcut({ ...props }: ShortcutProps) {
  return <ShortcutRoot {...props} />;
}

export default Shortcut;
