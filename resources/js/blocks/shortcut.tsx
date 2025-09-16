import { ShortcutRoot } from "@narsil-cms/components/shortcut";

type ShortcutProps = React.ComponentProps<typeof ShortcutRoot> & {};

function Shortcut({ ...props }: ShortcutProps) {
  return <ShortcutRoot {...props} />;
}

export default Shortcut;
