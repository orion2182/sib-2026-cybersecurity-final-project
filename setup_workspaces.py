"""Clone the three public lab repositories next to the planning documents.

Requires only Python 3 and Git. Existing Git checkouts are checked, never reset.
"""

from __future__ import annotations

import json
import subprocess
import sys
from pathlib import Path


ROOT = Path(__file__).resolve().parent
REPOS = (
    ("vapt-labs", "sib-2026-vapt-labs", "001-shared-lab-harness"),
    ("soc-labs", "sib-2026-soc-labs", "001-replay-evaluation-harness"),
    ("devsecops-labs", "sib-2026-devsecops-labs", "001-release-evaluation-harness"),
)


def run(*args: str) -> str:
    result = subprocess.run(args, check=True, text=True, capture_output=True)
    return result.stdout.strip()


def main() -> int:
    for directory, repo, default_feature in REPOS:
        path = ROOT / directory
        remote = f"https://github.com/orion2182/{repo}.git"
        if path.exists():
            if not (path / ".git").exists():
                print(f"ERROR: {path} exists but is not a Git checkout", file=sys.stderr)
                return 1
            configured = run("git", "-C", str(path), "remote", "get-url", "origin")
            allowed = {remote, remote.removesuffix(".git"), f"git@github.com:orion2182/{repo}.git"}
            if configured not in allowed:
                print(f"ERROR: {directory} has a different origin: {configured}", file=sys.stderr)
                return 1
            print(f"Exists: {directory} (no pull or reset performed)")
        else:
            print(f"Cloning: {repo}")
            subprocess.run(["git", "clone", remote, str(path)], check=True)

        feature_file = path / ".specify" / "feature.json"
        if not feature_file.exists():
            feature_file.write_text(
                json.dumps({"feature_directory": f"specs/{default_feature}"}) + "\n",
                encoding="utf-8",
            )
            print(f"Selected default feature: {directory}/{default_feature}")

    print("Ready. Start OpenCode inside one lab directory, such as soc-labs/.")
    return 0


if __name__ == "__main__":
    try:
        raise SystemExit(main())
    except (OSError, subprocess.CalledProcessError) as exc:
        print(f"ERROR: {exc}", file=sys.stderr)
        raise SystemExit(1) from exc
